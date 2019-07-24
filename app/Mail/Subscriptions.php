<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Subscriptions extends Mailable
{
    use Queueable, SerializesModels;
    protected $items;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($items)
    {
        $this->items = $items;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('chappie-36ea9d@inbox.mailtrap.io')
            ->view('rix.mail-template')
            ->with([
                'mail' => $this->items
            ]);
    }
}
