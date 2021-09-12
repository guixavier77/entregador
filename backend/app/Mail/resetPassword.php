<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class resetPassword extends Mailable
{
    use Queueable, SerializesModels;

    private $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Authenticatable $user)
    {
        $this->user = $user;
    }

    public function build()
    {
        $this->subject('Recuperar acesso ao Sistema');
        $this->to($this->user->email, $this->user->name);
        return $this->markdown('Mail.resetPassword', [
            'user' => $this->user
        ]);
    }
}
