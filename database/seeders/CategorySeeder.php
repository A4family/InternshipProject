<?php

namespace Database\Seeders;

use Carbon\Carbon;
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
        DB::table('categories')->insert([
            'category_name' => 'Electronics',
            'parent_id' => null,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

        ]);

        DB::table('categories')->insert([
            'category_name' => 'Home Appliance',
            'parent_id' => null,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

        ]);

        DB::table('categories')->insert([
            'category_name' => 'Fragrances',
            'parent_id' => null,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

        ]);

        DB::table('categories')->insert([
            'category_name' => 'Laptop',
            'parent_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

        ]);

        DB::table('categories')->insert([
            'category_name' => 'Acer Laptop',
            'parent_id' => 4,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

        ]);

        DB::table('categories')->insert([
            'category_name' => 'Television',
            'parent_id' => 2,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

        ]);

        DB::table('categories')->insert([
            'category_name' => 'Samsung Television',
            'parent_id' => 6,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

        ]);

        DB::table('categories')->insert([
            'category_name' => 'Men Fragrance',
            'parent_id' => 3,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

        ]);

        DB::table('categories')->insert([
            'category_name' => 'Loreal',
            'parent_id' => 8,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

        ]);

    }
}
