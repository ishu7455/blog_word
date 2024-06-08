@extends('layouts.app')

@section('title', $post->title)

@section('content')
<div class="mx-auto max-w-2xl px-2">
    <div class="py-6">
        <img src="{{ Storage::url($post->image) }}" class="aspect-w-16 aspect-h-9 w-full rounded-md mt-4" alt="{{ $post->title }}" />
        <h1 class="text-3xl font-bold text-gray-900">{{ $post->title }}</h1>
        <p class="mt-4 text-sm leading-normal text-gray-600">{{ $post->discription }}</p>
        
        <div class="flex items-center mt-4 space-x-4">
            <button id="like-button" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold py-2 px-4 rounded">
                Like
            </button>
            <span class="text-gray-600" id="like-count">{{ $post->likes->count() }} Likes</span>
            @if(Auth::user()->id == $post->user_id)
            <a href="{{ route('posts.edit', $post) }}" class="bg-blue-200 hover:bg-skyblue-300 text-gray-700 font-semibold py-2 px-4 rounded">
                Edit
            </a>
            <a href="{{ route('posts.destroy', $post) }}" class="bg-red-200 hover:bg-red-300 text-gray-700 font-semibold py-2 px-4 rounded">
                Delete
            </a>
            @endif
            <button id="email-share-button" class="bg-gray-500 hover:bg-gray-600 text-white font-semibold py-2 px-4 rounded">
                Share via Email
            </button>
        </div>

        
        <div class="mt-6">
            <h2 class="text-xl font-semibold text-gray-900">Comments</h2>
            
            <form action="{{ route('posts.comment', $post->id) }}" method="POST" class="mt-4">
                @csrf
                <textarea name="content" class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring focus:border-blue-300" rows="3" placeholder="Write your comment here..." required></textarea>
                <button type="submit" class="mt-2 px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:bg-blue-600">Submit</button>
            </form>
            
            <div class="mt-6">
                @foreach($post->comments as $comment)
                    <div class="flex items-start space-x-4 mt-4">
                        <img src="{{ $comment->user->avatar_url ?? 'https://via.placeholder.com/40' }}" class="w-10 h-10 rounded-full" alt="Avatar">
                        <div>
                            <p class="font-semibold">{{ $comment->user->name }}</p>
                            <p class="text-gray-600">{{ $comment->content }}</p>
                            
                            <div class="flex items-center mt-2 space-x-2">
                                <button class="comment-like-button bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold py-1 px-3 rounded" data-comment-id="{{ $comment->id }}">
                                    Like
                                </button>
                                <span class="text-gray-600 comment-like-count">{{ $comment->likes->count() }} Likes</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<!-- Modal for Email Share -->
<div id="email-share-modal" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black bg-opacity-50">
    <div class="bg-white rounded-lg p-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-4">Share via Email</h2>
        <form id="email-share-form" action="{{ route('posts.emailShare', $post->id) }}" method="POST">
            @csrf
            <label for="email" class="block text-gray-700">Recipient Email:</label>
            <input type="email" id="email" name="email" class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring focus:border-blue-300 mb-4" required>
            <button type="submit" class="w-full px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:bg-blue-600">Send</button>
            <button type="button" id="close-modal-button" class="w-full mt-2 px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 focus:outline-none focus:bg-gray-400">Cancel</button>
        </form>
    </div>
</div>

<script>
document.getElementById('like-button').addEventListener('click', function() {
    fetch('{{ route("posts.like", $post->id) }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({})
    })
    .then(response => response.json())
    .then(data => {
        let likeCount = document.getElementById('like-count');
        let likeButton = document.getElementById('like-button');

        let currentLikes = parseInt(likeCount.innerText.split(' ')[0]);
        if (data.message === 'Post liked successfully') {
            likeCount.innerText = `${currentLikes + 1} Likes`;
            likeButton.innerText = 'Dislike'; 
        } else if (data.message === 'Post disliked successfully') {
            likeCount.innerText = `${currentLikes - 1} Likes`;
            likeButton.innerText = 'Like'; 
        }
    });
});

document.querySelectorAll('.comment-like-button').forEach(button => {
    button.addEventListener('click', function() {
        let commentId = this.dataset.commentId;
        fetch(`/comment/${commentId}/like`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({})
        })
        .then(response => response.json())
        .then(data => {
            let likeCountSpan = this.nextElementSibling;
            let currentLikes = parseInt(likeCountSpan.innerText.split(' ')[0]);
            if (data.message === 'Comment liked successfully') {
                likeCountSpan.innerText = `${currentLikes + 1} Likes`;
                this.innerText = 'Dislike'; 
            } else if (data.message === 'Comment disliked successfully') {
                likeCountSpan.innerText = `${currentLikes - 1} Likes`;
                this.innerText = 'Like'; 
            }
        });
    });
});

document.getElementById('email-share-button').addEventListener('click', function() {
    document.getElementById('email-share-modal').classList.remove('hidden');
});

document.getElementById('close-modal-button').addEventListener('click', function() {
    document.getElementById('email-share-modal').classList.add('hidden');
});
</script>
@endsection
