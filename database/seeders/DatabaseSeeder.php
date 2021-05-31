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
            DepartmentSeeder::class,
            typeConsultSeeder::class,
            //PatientSeeder::class,
            BloodGroupSeeder::class,
            ServicePriceSeeder::class,
            lpiSeeder::class,
            lpiiSeeder::class,
            lpiiiSeeder::class,
            pregnancyProbSeeder::class,
            cervixLengthSeeder::class,
            cervixOpeningSeeder::class,
            cervixPositionSeeder::class,
            posBabySeeder::class,
            PresentationOfBabySeeder::class

        ]);
    }
}
