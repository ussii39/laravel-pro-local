<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Activation;

class ActivationCreated extends Mailable
{
    use Queueable, SerializesModels;
    protected $activation;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Activation $activation) {
        $this->activation = $activation;
      }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
  {
    $frontendURL = "https://tender-snyder-6bc78b.netlify.app";
    return $this->subject('アカウント有効化メール')
    ->markdown('emails.activations.created')
    ->with([
      'link' => $frontendURL."/verify/{$this->activation->code}"
    ]);
  }
}
