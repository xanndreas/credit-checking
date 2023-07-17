<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    public function run()
    {
        $products = [
            [
                'id'    => 1,
                'name' => 'Products Test',
                'aliases' => 'insurances-test',
            ],
        ];

        Product::insert($products);
    }
}
