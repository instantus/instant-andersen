<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AccountInactive extends Mailable
{
    use Queueable, SerializesModels;
    public $name;
    protected $pdf;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $pdf)
    {
        $this->name = $name;
        $this->pdf = $pdf;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.user.pdf')
            ->attachData($this->pdf->output(), 'Account_status_Laravel.pdf', ['mime' => 'application/pdf']);
    }
}
