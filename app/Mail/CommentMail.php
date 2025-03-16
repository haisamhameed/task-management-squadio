<?php

namespace App\Mail;

use App\Models\Comment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;

class CommentMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $comment;
    public function __construct($commentId)
    {
        $this->comment = Comment::with(['author:id,name,email', 'task' => function($query) {
            $query->with('author:id,name,email');
        }])->find($commentId);
    }

    public function build()
    {
        return $this->subject('New Comment on Task' . $this->comment->task->title)
                    ->view('emails.comment')
                    ->with(['comment' => $this->comment]);
    }
}
