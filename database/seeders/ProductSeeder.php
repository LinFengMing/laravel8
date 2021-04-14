<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::upsert([
            ['id' => 4, 'title' => '固定資料', 'content' => '固定內容', 'price' => rand(0, 30000), 'quantity' => 10],
            ['id' => 5, 'title' => '固定資料', 'content' => '固定內容', 'price' => rand(0, 30000), 'quantity' => 10]
        ], ['id'], ['price', 'quantity']);
    }
}
