<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Http\Request;

class OrderShipped extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(Request $request)
    {
        if($request->message != null){
        $mm = $request->message;
        }else{
            $mm = '';
        }
        return $this->from($request->email, 'Contact Us')
            ->subject('From Web: Contact Us' )
            ->markdown('mails.contact')
            ->with([
                'email' => $request->email,
                'mm' => $mm,

            ]);
    }
}
