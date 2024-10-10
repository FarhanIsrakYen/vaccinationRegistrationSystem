<?php

namespace App\Jobs;

use App\Models\User;
use App\Notifications\VaccinationScheduledNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendVaccinationScheduledEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;
    protected $vaccinationDate;
    protected $vaccineCenter;

    public function __construct(User $user, $vaccinationDate, $vaccineCenter)
    {
        $this->user = $user;
        $this->vaccinationDate = $vaccinationDate;
        $this->vaccineCenter = $vaccineCenter;
    }

    public function handle()
    {
        $this->user->notify(new VaccinationScheduledNotification($this->user, $this->vaccinationDate, $this->vaccineCenter));
    }
}
