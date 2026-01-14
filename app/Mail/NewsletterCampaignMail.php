<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewsletterCampaignMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    public function __construct(
        public string $recipientEmail,
        public string $subjectLine,
        public string $body
    ) {
        $this->subject($this->subjectLine);
    }

    public function build(): self
    {
        return $this->view('emails.newsletter.campaign')
            ->with([
                'recipientEmail' => $this->recipientEmail,
                'body' => $this->body,
            ]);
    }
}
