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
            ['name'=>'Ankany Avoko'],
        ]);
    }
}
