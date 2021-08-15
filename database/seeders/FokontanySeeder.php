<?php

namespace Database\Seeders;

use App\Models\Fokontany;
use Illuminate\Database\Seeder;

class FokontanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Fokontany::insert([
            ['name'=>'Ambovo'],
            ['name'=>'Atsimomparihy'],
            ['name'=>'Amboasary'],
            ['name'=>'Aanjondroa'],
            ['name'=>'Aarinarivo'],
            ['name'=>'Ambodisaha'],
            ['name'=>'Ambohinanjakana'],
            ['name'=>'Atanantanana'],
            ['name'=>'Andriantany'],
            ['name'=>'Iarinarivo'],
            ['name'=>'Manonilahy'],
            ['name'=>'Maroloha'],
            ['name'=>'Tsarazaza'],
            ['name'=>'Ambohidehilahy'],
            ['name'=>'Ampanataovana'],
        ]);
    }
}
