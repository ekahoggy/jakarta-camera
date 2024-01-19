<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerifikaiEmail extends Mailable
{
    use Queueable, SerializesModels;
    protected $user;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('berbagi@wahanavisi.org')
                   ->view('page.auth.verifikasiEmail')
                   ->with(
                    [
                        'name' => $this->user->name,
                        'kode' => $this->user->kode,
                        'expired' => $this->user->email_expired
                    ]);
    }
}
