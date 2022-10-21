<?php

use Illuminate\Database\Seeder;
use App\Message;
use App\User;
use Carbon\Carbon;
use Faker\Generator as Faker;

class MessagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {   
        $users = User::all();

        foreach ($users as $user) {
            for($i = 0; $i < rand(50, 300); $i++){
                $new_message = new Message();
                $new_message->author = $faker->name($gender = 'male'|'female');
                $new_message->email = $faker->email();
                $new_message->content = $faker->text(300);
                $new_message->created_at = new Carbon($faker->dateTimeBetween('-3 years', '-1 day'));
                $new_message->updated_at = new Carbon($faker->dateTimeBetween('-3 years', '-1 day'));
                $new_message->user_id = $user->id;
                $new_message->save();
            }
        }
    }
}
