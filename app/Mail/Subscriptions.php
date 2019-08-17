<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Subscriptions extends Mailable
{
    use Queueable, SerializesModels;
    protected $items;
    protected $email;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($items, $email)
    {
        $this->items = $items;
        $this->email = $email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $name = isset($this->items->name) && !empty($this->items->name) ? $this->items->name : \Config::get('mail.from.name');
        $from = isset($this->items->email) && !empty($this->items->email) ? $this->items->email : \Config::get('mail.from.address');
        return $this->from($from, $name)
            ->view('rix.mail-template')
            ->with([
                'mail'            => $this->items,
                'unsubscribe_url' => url('/rix_actions?action=unsubscribe&token=' . $this->email['security'])
            ])->to($this->email['email']);
    }
}
