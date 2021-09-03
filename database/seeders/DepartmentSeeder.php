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
                "name"=>"Administration",
                "medical"=>0
            ],
            [
                "name"=>"Medical",
                "medical"=>1
            ],
            [
                "name"=>"Warehouse",
                "medical"=>0
            ],
            [
                "name"=>"Technical",
                "medical"=>0
            ],
            [
                "name"=>"Operations",
                "medical"=>0
            ],
            [
                "name"=>"Ministry",
                "medical"=>0
            ],
            [
                "name"=>"Transport",
                "medical"=>0
            ],
            [
                "name"=>"MBS",
                "medical"=>0
            ],
            [
                "name"=>"Communication",
                "medical"=>0
            ]
        ]);

    }
}
