<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MessageMailable extends Mailable
{
    use Queueable, SerializesModels;
    public $subject = "Te contactaron desde Focomotor.com.ar 🚘";
    public $data;
    public $vehicle;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data, $vehicle)
    {
        // $this->subject = "Te contactaron por el vehiculo " . $vehicle->title;
        $this->data = $data;
        $this->vehicle = $vehicle;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email.message');
    }
}
