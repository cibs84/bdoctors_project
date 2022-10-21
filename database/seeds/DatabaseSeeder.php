<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(SpecializationsTableSeeder::class);
        $this->call(BundlesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(ReviewsTableSeeder::class);
        $this->call(MessagesTableSeeder::class);
    }
}
