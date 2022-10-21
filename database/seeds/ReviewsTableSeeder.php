<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Review;
use Carbon\Carbon;
use Faker\Generator as Faker;

class ReviewsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $users = User::all();

        foreach($users as $user) {
            $max_reviews_number = rand(50, 300);
            $min_vote = 1;
            $max_vote = 4;
            if ($max_reviews_number > 100 && $max_reviews_number < 200) {
                $min_vote = 3;
                $max_vote = 5;
            }
            if($max_reviews_number < 100) {
                $min_vote = 4;
                $max_vote = 5;
            }
            for ($i=0; $i < $max_reviews_number; $i++) {
                $new_reviews = new Review();

                $new_reviews->author = $faker->name($gender = 'male'|'female');
                $new_reviews->content = $faker->text(300);
                $new_reviews->vote = $faker->numberBetween($min_vote, $max_vote);
                $new_reviews->user_id = $user->id;
                $new_reviews->created_at = new Carbon($faker->dateTimeBetween('-3 years', '-1 day'));
                $new_reviews->updated_at = new Carbon($faker->dateTimeBetween('-3 years', '-1 day'));
                $new_reviews->save();
            }
        }
    }
}
