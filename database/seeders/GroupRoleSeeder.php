<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GroupRoleSeeder extends Seeder
{
    public function run()
    {
        DB::table('group_roles')->insert([
            'role_id' => 2,
            'group_id' => 2,
            'app_id' => 1
        ]);
    }
}
