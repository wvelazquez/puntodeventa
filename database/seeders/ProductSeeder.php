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
        Product::create([
            'name' => 'LARAVEL Y LIVEWIRE',
            'cost' => 200,
            'price' => 350,
            'barcode' => 102323,
            'stock' => 1000,
            'alerts' => 10,
            'category_id' => 1,
            'image' => 'curso.png'
        ]);
        
        Product::create([
            'name' => 'JORDAN 1',
            'cost' => 500,
            'price' => 300,
            'barcode' => 12345543,
            'stock' => 3,
            'alerts' => 1,
            'category_id' => 2,
            'image' => 'jordan1.png'
        ]);

        Product::create([
            'name' => 'Huawey Y9P',
            'cost' => 2500,
            'price' => 1600,
            'barcode' => 484920,
            'stock' => 3,
            'alerts' => 1,
            'category_id' => 3,
            'image' => 'huaweyy9p.png'
        ]);

        Product::create([
            'name' => 'IMAC PRO',
            'cost' => 27000,
            'price' => 22000,
            'barcode' => 108492323,
            'stock' => 5,
            'alerts' => 2,
            'category_id' => 4,
            'image' => 'imacpro.png'
        ]);
    }
}
