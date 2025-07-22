<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuRoleSeeder extends Seeder
{
    public function run()
    {
        DB::table('menu_roles')->insert([
            [
                'role_id' => 1,
                'group_id' => 2,
                'menu_id' => 1,
                'status' => 1
            ],
            [
                'role_id' => 2,
                'group_id' => 2,
                'menu_id' => 2,
                'status' => 1
            ]
        ]);
    }
}
