<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReminderEmail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct()
    {
        // Pass any variables to the mailable here if needed
    }

    public function build()
    {
        return $this->from(get_settings('system_email'), get_settings('website_title'))
                    ->subject('Reminder: Timesheet Submission Required')
                    ->view('emails.reminder');  // Specify your email view here
    }
}
