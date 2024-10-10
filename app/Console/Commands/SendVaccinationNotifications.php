<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\VaccinationRegistration;
use App\Models\VaccineCenter;
use App\Notifications\VaccinationAlertNotification;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SendVaccinationNotifications extends Command
{
    protected $signature = 'send:vaccination-reminder';
    protected $description = 'Send reminder to users scheduled for vaccination tomorrow';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle(): void
    {
        $tomorrow = Carbon::now()->addDay()->format('Y-m-d');

        $registrations = VaccinationRegistration::where('scheduled_date', $tomorrow)->pluck('user_id');
        $users = User::whereIn('id', $registrations)->get();
        $vaccineCenters = VaccineCenter::pluck('name', 'id')->toArray();

        foreach ($users as $user) {
            $center = $vaccineCenters[$user->vaccinationRegistration->center_id];
            $user->notify(new VaccinationAlertNotification($user, $center));
        }

        $this->info('Notifications sent to users scheduled for tomorrow.');
    }
}
