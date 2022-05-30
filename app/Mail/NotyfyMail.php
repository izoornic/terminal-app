<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotyfyMail extends Mailable
{
    use Queueable, SerializesModels;

    public $emData;
    public $comments;
    
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($dt, $coments = null)
    {
        //
        $this->emData = $dt;
        $this->comments = $coments;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->emData['subject'])
            ->view('emails.demoMail', ['data' => $this->emData, 'komentari' => $this->comments]);
    }
}
