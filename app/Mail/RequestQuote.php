<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\UploadedFile;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class RequestQuote extends Mailable
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
        $mail = $this->from($request->email, 'Request A Quote')
            ->subject('From Web: Request A Quote' )
            ->view('mails.files')
            ->with('mm', $request->message);
        /** @var UploadedFile $image */
        foreach ($request->photos as $image) {
            //dd($image->getRealPath());
            $mail->attach($image->getRealPath(), array(
                'as' => $image->getClientOriginalName(),
                'mime' => $image->getMimeType())
            );
        }
        return $mail;
    }

}
