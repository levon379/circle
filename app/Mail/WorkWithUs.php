<?php

namespace App\Mail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Http\Request;
use Illuminate\Queue\SerializesModels;
use function Webmozart\Assert\Tests\StaticAnalysis\length;

class WorkWithUs extends Mailable
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
        $data = array(
            'message'=> $request->message,
            'email'=> $request->email,
            'sent'=> $request->work,

        );
        $files = $request->file('images');
        Mail::to('mails.files', compact('data'), function ($message) use($data, $files){
            $message->from($data['email']);
            $message->to('info@circletechnicaldesign.com')->subject('From Web: '.$data['sent']);

            if(isset($files)) {
                foreach($files as $file) {
                    $message->attach($file->getRealPath(), array(
                            'as' => $file->getClientOriginalName(), // If you want you can chnage original name to custom name
                            'mime' => $file->getMimeType())
                    );
                }
            }
        });

}
}
