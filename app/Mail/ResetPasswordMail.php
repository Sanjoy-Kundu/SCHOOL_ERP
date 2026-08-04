<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ResetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    
    public $resetUrl;
    public $name;

    /**
     * Custom Constructor
     */
    public function __construct(User $user, $token)
    {
        $this->name = $user->name; 
        $this->resetUrl = url('/reset-password/' . $token . '?email=' . urlencode($user->email));
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Reset Your Password - ' . config('app.name'),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.reset-password', 
        );
    }
}
