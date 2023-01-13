<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'firstName' => 'Admin',
            'lastName' => 'Admin',
            'phone' => '+11245789630',
            'role' => 'super_admin',
            'email' => 'admin@admin.com',
            'organization_id' => 1,
            'password' => Hash::make('123456789'),
        ]);
    }
}
