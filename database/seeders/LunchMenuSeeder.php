<?php

namespace Database\Seeders;

use App\Models\LunchMenu;
use Illuminate\Database\Seeder;

class LunchMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        LunchMenu::insert([
            ['name'=>'Standard menu','price'=>500],
            ['name'=>'Intermediary menu','price'=>3000],
            ['name'=>'VIP menu','price'=>5000]
        ]);
    }
}
