<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DonasiDoneEmail extends Mailable
{
    use Queueable, SerializesModels;
    protected $data;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('berbagi@wahanavisi.org')
                   ->view('page.donasi.donasiDoneEmail')
                   ->subject("Donasi Telah Kami Terima")
                   ->with(
                    [
                        'nominal' => $this->data->total_donation,
                        'nama'  => $this->data->name,
                    ]);
    }
}
