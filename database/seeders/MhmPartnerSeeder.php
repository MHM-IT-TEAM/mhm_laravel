<?php

namespace Database\Seeders;

use App\Models\MhmPartner;
use Illuminate\Database\Seeder;

class MhmPartnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        return MhmPartner::insert([
            ['name'=>'FAM'],
            ['name'=>'Ankany Avoko Ambohidratrimo'],
            ['name'=>'Ankany Famonjena (Orphanage)'],
            ['name'=>'Ampangabe'],
            ['name'=>'Assembly of God'],
            ['name'=>'Centre Alabri Miarinarivo'],
            ['name'=>'EPP Mahavelona'],
            ['name'=>'Mantasoa'],
            ['name'=>'Mission Pst Jean Noel'],
            ['name'=>'SOLTEC'],
        ]);
    }
}
