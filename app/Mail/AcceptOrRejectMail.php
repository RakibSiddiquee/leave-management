<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AcceptOrRejectMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $status, $leave;
    public function __construct($status, $leave)
    {
        $this->status = $status;
        $this->leave = $leave;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $status = $this->status;
        $leaveDetails = $this->leave;
        return $this->subject('Leave Request '. $status)
            ->view('mail-template.accept-reject', compact('status', 'leaveDetails'));

    }
}
