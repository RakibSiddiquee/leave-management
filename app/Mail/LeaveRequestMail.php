<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class LeaveRequestMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $leave, $totalDays;
    public function __construct($leave, $totalDays)
    {
        $this->leave = $leave;
        $this->totalDays = $totalDays;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $leaveDetails = $this->leave;
        $days = $this->totalDays;
        return $this->subject('Leave Request')
                ->view('mail-template.leave-request', compact('leaveDetails', 'days'));

    }
}
