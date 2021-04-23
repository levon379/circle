<?php

namespace App\Mail;
use Illuminate\Http\UploadedFile;
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
        $errorMessage = "";
        $success = true;
        try {
            $mail = $this->from($request->email, 'Work With Us')
                ->subject('From Web: Work With Us')
                ->view('mails.work')
                ->with('mm', $request->message);

            /** @var UploadedFile $image */
            foreach ($request->photos as $image) {
                $mail->attach($image->getRealPath(), array(
                        'as' => $image->getClientOriginalName(),
                        'mime' => $image->getMimeType())
                );
            }
        } catch (\Exception $e) {
            $errorMessage = $e->getMessage();
            $success = false;
        }
        return response()->json(['success' => $success, 'errorMessage' => $errorMessage]);
    }
}
