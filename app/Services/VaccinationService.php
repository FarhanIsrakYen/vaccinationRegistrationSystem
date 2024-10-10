<?php

namespace App\Services;

use App\Jobs\SendVaccinationScheduledEmail;
use App\Models\User;
use App\Models\VaccineCenter;
use App\Models\VaccinationRegistration;
use DateTime;
use Illuminate\Support\Facades\DB;

class VaccinationService
{
    public function registerUser($name, $email, $phone, $nid, $vaccine_center_id)
    {
        return DB::transaction(function () use ($name, $email, $phone, $nid, $vaccine_center_id) {
            $center = VaccineCenter::where('id', $vaccine_center_id)->lockForUpdate()->first();

            $lastScheduledDate = VaccinationRegistration::where('center_id', $vaccine_center_id)->orderByDesc('scheduled_date')
                ->value('scheduled_date');

            $nextWeekday = $this->getScheduleDate($lastScheduledDate, $center);

            $user = User::create(compact('name', 'email', 'phone', 'nid'));

            $scheduledDate = $this->scheduleVaccination($user, $vaccine_center_id, $nextWeekday);

            SendVaccinationScheduledEmail::dispatch($user, $scheduledDate, $center);

            return [
                'success' => true,
                'message' => 'Registration successful',
                'data' => [
                    'user_id' => $user->id,
                    'vaccine_center_id' => $center->name,
                    'scheduled_date' => $scheduledDate,
                ],
            ];
        });
    }

    protected function scheduleVaccination(User $user, $centerId, $scheduledDate)
    {
        VaccinationRegistration::create([
            'user_id' => $user->id,
            'center_id' => $centerId,
            'scheduled_date' => $scheduledDate,
        ]);

        return $scheduledDate;
    }

    private function getScheduleDate($lastScheduledDate = null, $center = null)
    {
        if (empty($lastScheduledDate)) {
            return self::getNextWeekday();
        }

        $currentCount = VaccinationRegistration::where('center_id', $center->id)
                            ->where('scheduled_date', $lastScheduledDate)
                            ->count();

        return ($currentCount >= $center->daily_limit)
            ? self::getNextWeekday($lastScheduledDate)
            : $lastScheduledDate;
    }

    protected function getNextWeekday($date = null) {
        $date = $date ? new DateTime($date) : new DateTime();
        $dayOfWeek = $date->format('w');
        $daysToAdd = ($dayOfWeek >= 4) ? (7 - $dayOfWeek) : 1;
        $date->modify("+$daysToAdd days");

        return $date->format('Y-m-d');
    }

    public function checkRegistrationStatus($nid)
    {
        $user = User::where('nid', $nid)->first();

        if (!$user) {
            return 'Not registered';
        }

        $vaccinationRegistration = VaccinationRegistration::where('user_id', $user->id)->select('scheduled_date')->first();

        if (!empty($vaccinationRegistration) && $vaccinationRegistration['scheduled_date']) {
            if ($vaccinationRegistration['scheduled_date'] < now()) {
                return 'Vaccinated';
            }
            return 'Scheduled: ' . $vaccinationRegistration['scheduled_date'];
        }

        return 'Not scheduled';
    }
}
