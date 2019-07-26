<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class Subscriptions implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $items;
    protected $emails;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($items, $emails)
    {
        $this->items = $items;
        $this->emails = $emails;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->emails as $email) {
            \Mail::send(new \App\Mail\Subscriptions($this->items, $email['emal']));
            sleep(5);
        }
    }
}
