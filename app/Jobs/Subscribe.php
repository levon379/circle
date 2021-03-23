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

    protected $to;
    protected $mail;

    /**
     * Create a new job instance.
     * @return void
     */
    public function __construct($to, $mail)
    {
        $this->to = $to;
        $this->mail = $mail;
    }

    /**
     * Execute the job.
     * @return void
     */
    public function handle()
    {
        $details = $this->mail;
        $mailable = new SubscriberMail($details);
        $mailable->html(nl2br($details['message']));
        Mail::to($this->to)->send($mailable);
    }
}
