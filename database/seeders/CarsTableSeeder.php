<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CarsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cars')->insert([
            'name' => '車A',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('cars')->insert([
            'name' => '車B',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('cars')->insert([
            'name' => '車C',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
