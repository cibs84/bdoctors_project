<?php

use Illuminate\Database\Seeder;
use App\Bundle;
use Faker\Generator as Faker;
use Carbon\Carbon;

class BundlesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $bundles = [
            [
                'name' => 'bronze',
                'price' => 2.99,
                'duration' => 1 
            ],
            [
                'name' => 'silver',
                'price' => 5.99,
                'duration' => 3
            ],
            [
                'name' => 'gold',
                'price' => 9.99,
                'duration' => 6
            ]
        ];

        foreach ($bundles as $bundle) {
            $new_bundle = new Bundle();

            $new_bundle->price = $bundle['price'];
            $new_bundle->name = $bundle['name'];
            $new_bundle->code = $faker->ean13();
            $new_bundle->duration = $bundle['duration'];
            $new_bundle->save();
        }
    }
}
