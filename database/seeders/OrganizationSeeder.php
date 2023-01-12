<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrganizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('organizations')->insert([
            'name' => Str::random(5),
            'description' => Str::random(10),
            'address' => Str::random(10),
            'state' => Str::random(5),
            'city' => Str::random(5),
            'logo' => Str::random(10),
            'timezone' => Str::random(4),
            'currency' => Str::random(3),
        ]);
    }
}
