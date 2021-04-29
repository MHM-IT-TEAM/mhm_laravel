<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Department::truncate();
        DB::table('departments')->insert([
            [
                "name"=>"JoyCenter",
                "medical"=>0
            ],
            [
                "name"=>"Grace Center",
                "medical"=>0
            ],
            [
                "name"=>"Generalist",
                "medical"=>1
            ],
            [
                "name"=>"Dentist",
                "medical"=>1
            ],
            [
                "name"=>"Pink",
                "medical"=>1
            ],
            [
                "name"=>"Cashier",
                "medical"=>0
            ]
        ]);

    }
}
