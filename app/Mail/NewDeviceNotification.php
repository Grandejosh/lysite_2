<?php

namespace App\Mail;

use App\Models\UserDevice;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewDeviceNotification extends Mailable
{
    use Queueable, SerializesModels;

    protected $device;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(UserDevice $device)
    {
        $this->device = $device;
    }


    public function build()
    {
        return $this->subject('Nuevo dispositivo detectado')
            ->view('emails.new-device')
            ->with([
                'device' => $this->device,
                'verificationLink' => route('verify.device', [
                    'id' => $this->device->id,
                    'token' => $this->device->token
                ]),
            ]);
    }
}
