<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ConfirmMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    public $subject;
    public $viewName;

    /**
     * Create a new message instance.
     * @param $data
     * @param $subject
     * @param $viewName
     * @return void
     */
    public function __construct($data, $subject, $viewName)
    {
        $this->data = $data;
        $this->subject = $subject;
        $this->viewName = $viewName;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->from($address = config('mail.from.address'), $name = config('mail.from.name'))
            ->subject($this->subject)
            ->view($this->viewName)
            ->with(['data' => $this->data]);
    }
}
