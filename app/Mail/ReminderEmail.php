<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReminderEmail extends Mailable
{
    use Queueable, SerializesModels;
    public $message;

    public function __construct($message)
    {
        $this->message = $message;
        // Pass any variables to the mailable here if needed
    }

    public function build()
    {
        return $this->from(get_settings('system_email'), get_settings('website_title'))
                    ->subject('Reminder: Timesheet Submission Required')
                    ->text('emails.simple', ['content' => $this->message]);
                    //->view($this->message);  // Specify your email view here
    }
}
