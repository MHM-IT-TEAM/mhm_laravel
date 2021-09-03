<?php

namespace Database\Seeders;

use App\Models\CervixOpening;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call([
            ProjectSeeder::class,
            DivisionSeeder::class,
            CategorySeeder::class,
            ServiceSeeder::class,
            PatientCategorySeeder::class,
            MhmPartnerSeeder::class,
            PageSeeder::class,
            FokontanySeeder::class,
            AnaesthetistConsultationSeeder::class,
            SeniorSeeder::class,
            AdmissionPrioritySeeder::class,
//            BirthTypeSeeder::class,
//            HospitalServiceDivisionSeeder::class,
//            HospitalServiceSeeder::class,
//            PresentationOfBabySeeder::class,
//            posBabySeeder::class,
//            cervixPositionSeeder::class,
//            cervixOpeningSeeder::class,
//            cervixLengthSeeder::class,
//            pregnancyProbSeeder::class,
//            lpiiiSeeder::class,
//            lpiiSeeder::class,
//            lpiSeeder::class,
//            BloodGroupSeeder::class,


        ]);
    }
}
