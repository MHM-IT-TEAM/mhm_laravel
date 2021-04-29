<?php

namespace Database\Seeders;

use App\Models\lpii;
use Illuminate\Database\Seeder;

class lpiiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        lpii::insert([
            ["name"=>'L'],
            ["name"=>'R'],
            ["name"=>'Anterior'],
            ["name"=>'Posterior'],
            ["name"=>'Up'],
            ["name"=>'Down'],

    ]);
    }
}
