<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GroupSeeder extends Seeder
{
    public function run()
    {
        $groups = array(
            [
                'group_id' => 2,
                'group_name' => 'HR',
                'group_desc' => 'HRD',
                'status' => 1
            ],
            [
                'group_id' => 3,
                'group_name' => 'LEADER',
                'group_desc' => 'LEADER',
                'status' => 1
            ],
            [
                'group_id' => 4,
                'group_name' => 'KARYAWAN',
                'group_desc' => 'KARYAWAN',
                'status' => 1
            ],
            [
                'group_id' => 7,
                'group_name' => 'GUEST',
                'group_desc' => 'GUEST',
                'status' => 1
            ]
        );
        DB::table('groups')->insert($groups);
    }
}
