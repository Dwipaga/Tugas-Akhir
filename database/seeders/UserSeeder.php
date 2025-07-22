<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            'user_id' => 2,
            'group_id' => 2,
            'email' => 'aria.blackmore@gmail.com',
            'divisi' => 'PROGRAMMER',
            'alamat' => 'mlg',
            'tempat_lahir' => 'mlg',
            'firstname' => 'Aria B',
            'lastname' => 'Blackmore',
            'phone' => '0212555555',
            'photo' => '1.jpg',
            'password' => '017bd5c7b42bd5909ab767e072e5a5e7',
            'dokumen' => '1.pdf',
            'created' => '2021-09-22 22:50:22',
            'status' => 1
        ]);
    }
}