<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;

    public $addressFrom;
    public $name;
    public $subject;
    public $content;

    /**
     * Create a new message instance.
     * @param  $name
     * @param  $addressFrom
     * @param  $subject
     * @param  $content
     * @return void
     */
    public function __construct( $name, $addressFrom, $content,  $subject = '')
    {
        $this->addressFrom = $addressFrom;
        $this->name = $name;
        $this->subject = $subject;
        $this->content = $content;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->from($address = $this->addressFrom, $name = $this->name)
            ->subject($this->subject)
            ->view('fontend.contact.mail')
            ->with(['content' => 'this is message']);
    }
}
