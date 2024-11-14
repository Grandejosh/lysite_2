<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\ComplaintBook;

class EmailComplaintBookNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $complaintBook;
    public $subject;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($complaintBook, $subject = null)
    {
        if($subject)
        {
            $this->subject = $subject;
        }else{
            $this->subject = "Notificación Libro de Reclamaciones - " . env('APP_NAME');
        }

        $this->complaintBook = $complaintBook;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function build()
    {
        return $this->view('complaintbook.email_notification', [
            'complaintBook' => $this->complaintBook
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
