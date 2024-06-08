<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Post;



class SharePost extends Mailable
{
    use Queueable, SerializesModels;

    public $post;
    public $email;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Post $post, $email)
    {
        $this->post = $post;
        $this->email = $email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Check out this post')
                    ->view('posts.sharePost');
    }
}
