<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'category_name' => 'makanan',
                'description' => 'All food items',
            ],
            [
                'category_name' => 'minuman',
                'description' => 'All drinks and beverages',
            ],
        ];
        DB::table('categorie.categories')->insert($categories);
    }
}
