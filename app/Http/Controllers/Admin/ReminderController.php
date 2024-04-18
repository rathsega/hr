<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\{Clients, Billable_timesheets, User, Reminder_logs};
use App\Mail\ReminderEmail;
use Mail;
use Carbon\Carbon;

use Illuminate\Http\Request;

class ReminderController extends Controller
{
    function index()
    {
        $this->sendReminders();
        //fetch clients
        //$clients = $this->getAllActiveClients();

        //fetch users related to a client

        //send remider if timesheet not uploaded

    }

    public function getAllActiveClients()
    {
        return Clients::select("select * form clients where status='active'");
    }

    public function sendReminders()
    {
        $today = Carbon::today();
        $clients = Clients::all();

        foreach ($clients as $client) {
            if ($today->day >= ($client->reminder_type-2) && $today->day <= $client->reminder_type) {
                $this->handleMonthlyReminder($client, $today);
            }
        }
    }

    protected function handleWeeklyReminder($client, $today)
    {
        // Check if today is within the last three days of this week
        if ($today->dayOfWeek >= Carbon::FRIDAY) { // Assuming the week ends on Sunday
            $this->checkAndSendReminders($client, $today);
        }
    }

    protected function handleBiWeeklyReminder($client, $today)
    {
        // Define your bi-weekly logic here. You might need a reference date.
        // Assuming bi-weekly periods start from the beginning of this year
        $startOfYear = Carbon::createFromDate($today->year, 1, 1);
        $weeksSinceStart = $today->diffInWeeks($startOfYear);

        if ($weeksSinceStart % 2 == 0 && $today->dayOfWeek >= Carbon::FRIDAY) {
            $this->checkAndSendReminders($client, $today);
        }
    }

    protected function handleMonthlyReminder($client, $today)
    {

        // Get the last day of the current month
        $lastDayOfMonth = Carbon::now()->endOfMonth();

        // Get the second last day of the current month
        $secondLastDayOfMonth = Carbon::now()->endOfMonth()->subDay(1);

        // Get the third last day of the current month
        $thirdLastDayOfMonth = Carbon::now()->endOfMonth()->subDay(2);

        $now = Carbon::now();
        $message = "";
        // Checking if today is one of these days
        if ($today->day == $client->reminder_type - 2) {
            $message =  "Dear Associate, \n Please share us the Approved timesheets for the month of ". $now->format('m') ."-". $now->format('Y') ." on priority. \n\n  Regards,\nHR,\nZettamine Labs Pvt. Ltd.";
        }

        if ($today->day == $client->reminder_type - 1) {
            $message =  "Dear Associate, \n Please share us the Approved timesheets for the month of ". $now->format('m') ."-". $now->format('Y')." \n\n  Regards,\nHR,\nZettamine Labs Pvt. Ltd.";
        }

        if ($today->day == $client->reminder_type) {
            $message =  "Dear Associate, \n \n This is a gentle reminder to share us the Approved timesheets for the month of ". $now->format('m') ."-". $now->format('Y') ." as early as you receive it. \n\n  Regards,\nHR,\nZettamine Labs Pvt. Ltd.";
        }

        // Check if today is within the last three days of the month
        //if ($today->day > $today->endOfMonth()->subDays(3)->day) {
            $this->checkAndSendReminders($client, $today, $message);
        //}
    }

    protected function checkAndSendReminders($client, $today, $message = "")
    {
        $users = User::where('client', $client->id)->where('billingtype', 'billable')->get();

        $monthStart = Carbon::now()->startOfMonth()->toDateString();  // format: "YYYY-MM-DD"

        // Current month end
        $monthEnd = Carbon::now()->endOfMonth()->toDateString(); 

        foreach ($users as $user) {
            // Check if timesheet has been submitted
            $timesheetSubmitted = Billable_timesheets::where('user_id', $user->id)
                ->whereBetween('from_date', [$monthStart, $monthEnd])
                ->exists();

            if (!$timesheetSubmitted) {
                // Send Reminder
                Mail::to($user->email)->send(new ReminderEmail($message));

                // Log Reminder
                Reminder_logs::create([
                    'user_id' => $user->id,
                    'date_time' => $today
                ]);
            }
        }
    }
}
