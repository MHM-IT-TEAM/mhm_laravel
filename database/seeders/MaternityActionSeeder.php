<?php

namespace Database\Seeders;

use App\Models\MaternityActionList;
use Illuminate\Database\Seeder;

class MaternityActionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MaternityActionList::insert(
            ['name']
        );
    }
}
