<?php

namespace App\Jobs;

use App\Mail\SubscriberMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class Subscribe implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $subscriber;
    protected $mail;

    /**
     * Create a new job instance.
     * @return void
     */
    public function __construct($subscriber, $mail)
    {
        $this->subscriber = $subscriber;
        $this->mail = $mail;
    }

    /**
     * Execute the job.
     * @return void
     */
    public function handle()
    {
        $subscriber = $this->subscriber;
        $details = $this->mail;
        Mail::to($subscriber)->send(new SubscriberMail($details));
    }
}
