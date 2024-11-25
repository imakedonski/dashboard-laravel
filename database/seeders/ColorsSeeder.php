<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ColorsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('colors')->insert([
            'name' => 'blue',
            'hex_value' => '3b82f6',
        ]);

        DB::table('colors')->insert([
            'name' => 'red',
            'hex_value' => 'dc2626',
        ]);

        DB::table('colors')->insert([
            'name' => 'yellow',
            'hex_value' => 'eab308',
        ]);
    }
}
