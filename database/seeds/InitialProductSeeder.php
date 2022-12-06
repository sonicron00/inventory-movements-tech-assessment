<?php

use App\Models\Product;

class InitialProductSeeder extends DatabaseSeeder
{
    /**
     * Create an initial product on which the preceding seeded transactions
     * can reference.
     * @return void
     */
    public function run()
    {
        Product::create(
            [
                'external_id' => Str::random(10),
                'description' => 'Figgie Fertiliser',
                'created_at' => NOW(),
                'updated_at' => NOW()
            ]
        );
    }

}