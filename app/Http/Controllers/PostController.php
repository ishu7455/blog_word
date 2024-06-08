<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use App\Models\Post;
use App\Models\Like;
use App\Models\Comment;
use App\Models\CommentLike;
use Illuminate\Support\Facades\Mail;
use App\Mail\SharePost;

class PostController extends Controller
{   
    public function index(Request $request)
    {
        $search = $request->input('search');

        $posts = Post::with('user')
                    ->where(function($query) use ($search) {
                        $query->where('title', 'like', '%'.$search.'%');
                    })
                    ->paginate(5);

        return view('posts.index', compact('posts'));
    }
    
    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {   
        $request->validate([
            'title' => 'required|max:255',
            'discription' => 'required|max:255',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048', 
        ]);
    
        if ($request->hasFile('image')) {
            $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
            $imagePath = $request->file('image')->storeAs('uploads', $imageName, 'public');
        } else {
            $imagePath = null;
        }
    
        Post::create([
            'title' => $request->title,
            'discription' => $request->discription,
            'image' => $imagePath,
            'user_id' => auth()->id(), 
        ]);
    
        return redirect()->route('index')->with('success', 'Post created successfully!');
    }

    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }

    public function likePost(Request $request, $postId)
    {
        $user = Auth::user();
    
        $existing_like = Like::where('user_id', $user->id)->where('post_id', $postId)->first();
    
        if ($existing_like) {
            $existing_like->delete();
            return response()->json(['message' => 'Post disliked successfully']);
        } else {
            Like::create([
                'user_id' => $user->id,
                'post_id' => $postId
            ]);
            return response()->json(['message' => 'Post liked successfully']);
        }
    }
    
    public function addComment(Request $request, $postId)
    {
        $request->validate([
            'content' => 'required|string|max:255',
        ]);
    
        Comment::create([
            'user_id' => Auth::id(),
            'post_id' => $postId,
            'content' => $request->input('content'),
        ]);
    
        return back()->with('success', 'Comment added successfully');
    }

    public function likeComment(Request $request, $commentId)
    {
        $user = Auth::user();

        $existing_like = CommentLike::where('user_id', $user->id)->where('comment_id', $commentId)->first();

        if ($existing_like) {
            $existing_like->delete();
            return response()->json(['message' => 'Comment disliked successfully']);
        } else {
            CommentLike::create([
                'user_id' => $user->id,
                'comment_id' => $commentId
            ]);
            return response()->json(['message' => 'Comment liked successfully']);
        }
    }
    public function destroy(Post $post)
    {
        if ($post->user_id !== auth()->id()) {
            return redirect()->route('index')->with('error', 'You are not authorized to delete this post.');
        }
    
        $post->delete();
        return redirect()->route('index')->with('success', 'Post deleted successfully.');
    }

    public function edit(Post $post)
    {
        if ($post->user_id !== auth()->id()) {
            return redirect()->route('index')->with('error', 'You are not authorized to edit this post.');
        }
    
        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        if ($post->user_id !== auth()->id()) {
            return redirect()->route('index')->with('error', 'You are not authorized to update this post.');
        }
    
        if ($request->hasFile('image')) {
            $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
            $imagePath = $request->file('image')->storeAs('uploads', $imageName, 'public');
        } else {
            $imagePath = $post->image;
        }
      
        Post::where('id',$post->id)->update([
            'title' => $request->title,
            'discription' => $request->discription,
            'image' => $imagePath,
            'user_id' => auth()->id(), 
        ]);
        return redirect()->route('index', $post)->with('success', 'Post updated successfully.');
    }

    public function emailShare(Request $request, Post $post)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        Mail::to($request->email)->send(new SharePost($post, $request->email));

        return back()->with('success', 'Email sent successfully!');
    }
}  
