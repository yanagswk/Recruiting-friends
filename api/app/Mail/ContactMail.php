<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(array $contact)
    {
        $this->game_name = $contact["game_name"];
        $this->hardware_name = $contact["hardware_name"];
        $this->user_message = $contact["user_message"];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from("yanagimassu@gmail.com")
            ->subject("追加してほしいゲームのお問い合わせ")
            ->view('emails.contact')
            ->with([
                'game_name' => $this->game_name,
                'hardware_name' => $this->hardware_name,
                'user_message' => $this->user_message,
            ]);
    }
}