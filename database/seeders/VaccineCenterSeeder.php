<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VaccineCenterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $vaccineCenters = [
            [
                'name' => 'ABC Health Center',
                'location' => 'TestPlace1',
                'daily_limit' => 10,
            ],
            [
                'name' => 'ABC Health Clinic',
                'location' => 'TestPlace2',
                'daily_limit' => 5,
            ],
            [
                'name' => 'ABC Medical Center',
                'location' => 'TestPlace3',
                'daily_limit' => 7,
            ],
            [
                'name' => 'ABC Vaccination Hub',
                'location' => 'TestPlace4',
                'daily_limit' => 15,
            ],
            [
                'name' => 'ABC Health Office',
                'location' => 'TestPlace5',
                'daily_limit' => 8,
            ],
            [
                'name' => 'ABC Vaccination Center',
                'location' => 'TestPlace6',
                'daily_limit' => 20,
            ],
            [
                'name' => 'ABC Health Facility',
                'location' => 'TestPlace7',
                'daily_limit' => 6,
            ],
            [
                'name' => 'ABC Immunization Clinic',
                'location' => 'TestPlace8',
                'daily_limit' => 9,
            ],
            [
                'name' => 'DEF Vaccination Center',
                'location' => 'TestPlace9',
                'daily_limit' => 12,
            ],
            [
                'name' => 'Health and Wellness Center',
                'location' => 'TestPlace10',
                'daily_limit' => 11,
            ],
        ];

        DB::table('vaccine_centers')->insert($vaccineCenters);
    }
}
