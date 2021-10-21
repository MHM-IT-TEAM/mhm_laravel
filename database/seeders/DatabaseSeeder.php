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
            //system in gl
            ProjectSeeder::class,
            DivisionSeeder::class,
            CategorySeeder::class,
            ServiceSeeder::class,
            //joyCenter related
            PatientCategorySeeder::class,
            MhmPartnerSeeder::class,
            PageSeeder::class,
            FokontanySeeder::class,
            AnaesthetistConsultationSeeder::class,
            SeniorSeeder::class,
            AdmissionPrioritySeeder::class,
            AdmissionTypeSeeder::class,
            //generalist
            DiagCodeSeeder::class,
            //internal lab work
            LabWorkStepSeeder::class,
            //inventory system
            ItemTypeSeeder::class,
            ItemUnitSeeder::class,
            ItemAdministrationSeeder::class,
            LocationSeeder::class,
            CollectorSeeder::class,
            StorageResponsibleSeeder::class,
            InternalConsultationTypeSeeder::class,
            CarSeeder::class,
            MedicalCenterSeeder::class,
            AppointmentStatusSeeder::class,



        ]);
    }
}
