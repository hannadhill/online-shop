<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = now();
        DB::table('categories')->insert([
            'name' => 'Category A',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        DB::table('categories')->insert([
            'name' => 'Category B',
            'created_at' => $now,
            'updated_at' => $now,
        ]);
    }
}
