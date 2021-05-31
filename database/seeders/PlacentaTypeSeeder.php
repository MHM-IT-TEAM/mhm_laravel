<?php

namespace Database\Seeders;

use App\Models\PlacentaType;
use Illuminate\Database\Seeder;

class PlacentaTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PlacentaType::insert([
            ['name'=>'Anterior'],
            ['name'=>'Posterior'],
            ['name'=>'Fundal'],
            ['name'=>'Lateral'],
            ['name'=>'Previa'],
        ]);
    }
}
