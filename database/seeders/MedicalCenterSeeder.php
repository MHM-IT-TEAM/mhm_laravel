<?php

namespace Database\Seeders;

use App\Models\MedicalCenter;
use Illuminate\Database\Seeder;

class MedicalCenterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MedicalCenter::insert([
            ['name'=>'HJRA'],
            ['name'=>'Anosiala'],
            ['name'=>'Befelatanana'],
            ['name'=>'CAM'],
            ['name'=>'GNTP'],
            ['name'=>'HOMI'],
            ['name'=>'IP'],
            ['name'=>'PSF'],
            ['name'=>'TPLA'],
        ]);
    }
}
