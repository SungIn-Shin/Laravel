<?php

namespace App\Mail;

use App\Document;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class RejectMailer extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $document;

    public $subject;
    // private $document;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Document $document)
    {
        //
        $this->document = $document;
        $this->subject = $document->document_name . ' - 반려알림';
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {   
        // with 함수를 지정하지 않아도 mail.blade.php에서 이 class에 설정한 public $document; 를 호출할 수 있다
        // return $this->view('mail')->with('document', $this->document);
        return $this->view('mail');
    }
}
