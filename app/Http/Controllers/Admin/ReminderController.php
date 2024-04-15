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
    function index(){
        $this->sendReminders();
        //fetch clients
        //$clients = $this->getAllActiveClients();

        //fetch users related to a client

        //send remider if timesheet not uploaded

    }

    public function getAllActiveClients(){
        return Clients::select("select * form clients where status='active'");
    }

    public function sendReminders()
    {
        $today = Carbon::today();
        $clients = Clients::all();

        foreach ($clients as $client) {
            switch ($client->reminder_type) {
                case 'Weekly':
                    $this->handleWeeklyReminder($client, $today);
                    break;
                case 'Bi-Weekly':
                    $this->handleBiWeeklyReminder($client, $today);
                    break;
                case 'Monthly':
                    $this->handleMonthlyReminder($client, $today);
                    break;
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
        // Check if today is within the last three days of the month
        if ($today->day > $today->endOfMonth()->subDays(3)->day) {
            $this->checkAndSendReminders($client, $today);
        }
    }

    protected function checkAndSendReminders($client, $today)
    {
        $users = User::where('client', $client->id)->get();

        foreach ($users as $user) {
            // Check if timesheet has been submitted
            $timesheetSubmitted = Billable_timesheets::where('user_id', $user->id)
                ->whereBetween('from_date', [$today->startOfWeek(), $today->endOfWeek()])
                ->exists();

            if (!$timesheetSubmitted) {
                // Send Reminder
                Mail::to($user->email)->send(new ReminderEmail());

                // Log Reminder
                Reminder_logs::create([
                    'user_id' => $user->id,
                    'date_time' => $today
                ]);
            }
        }
    }

    
}