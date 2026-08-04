<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\URL;
use Illuminate\Queue\SerializesModels;

class VerificationMail extends Mailable
{
    use Queueable, SerializesModels;
    public User $user;
    /**
     * Create a new message instance.
     */
    public function __construct(User $user)
    {
         $this->user = $user;
    }

      public function build()
    {
       
        $verificationUrl = URL::temporarySignedRoute(
            'custom.verification.verify', 
            now()->addMinutes(60),
            ['id' => $this->user->id, 'hash' => sha1($this->user->email)]
        );


        return $this->subject('Verify Your Email Address-'. config('app.name'))
                    ->view('emails.custom-verification', [
                        'verificationUrl' => $verificationUrl,
                    ]);
    }
}
