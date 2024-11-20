<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\ComplaintBook;

class ComplaintBookReply extends Mailable
{
    use Queueable, SerializesModels;

    public $complaintBook;
    public $subject;
    public $reply;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($complaintBook, $reply, $subject = null)
    {
        if($subject != null)
        {
            $this->subject = $subject . " - Reclamo/Queja - " . env('APP_NAME');
        }else{
            $this->subject = "Respuesta a Libro de Reclamaciones - " . env('APP_NAME');
        }

        $this->complaintBook = $complaintBook;
        $this->reply = $reply;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function build()
    {
        return $this->view('complaintbook.email_notification', [
            'complaintBook' => $this->complaintBook,
            'reply' => $this->reply
        ]);
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
