<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use App\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Specialization;
use Carbon\Carbon;
use App\Bundle;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {

        for($i = 0; $i < 150; $i++) {
            // Chiamata api RANDOM USER GENERATOR per picture profile
            $response = Http::withoutVerifying()->get('https://randomuser.me/api/');
            $apiResponse = $response->json();

            // Creazione nuovo utente
            $new_user = new User();
            $new_user->name = $faker->name($gender = 'male'|'female'); 
            $new_user->address = $faker->streetAddress(); 
            $new_user->phone_number = $faker->e164PhoneNumber();
            $new_user->email = $faker->email();
            $new_user->curriculum = $faker->text(3000);
            // $new_user->photo = 'https://s3-eu-west-1.amazonaws.com/miodottore.it/doctor/b26aee/b26aee7167aa5d475a7761d55f2e6bbd_large.jpg';
            $new_user->photo = $apiResponse['results'][0]['picture']['large'];
            $new_user->slug = $this->getFreeSlugFromTitle($new_user->name);
            $new_user->password = Hash::make('password123');
            $new_user->service = implode(', ', $faker->words(rand(5,15)));
            $new_user->save();

            $specialization_ids = []; 

            for($j = 1; $j <= rand(1, 3); $j++) { 
                $id_random = rand(1, 8);

                if(!in_array( $id_random, $specialization_ids)) {
                    $specialization_ids[] = $id_random;
                } 
            }

            $new_user->specializations()->sync($specialization_ids);
            

            // ***********************************************************
            // USER_BUNDLE SEEDER
            // ***********************************************************
            $bundle_ids = [];
            $bundle_expired_dates = [];

            for($z = 1; $z <= rand(1, 10); $z++) {
                $id_bundle_random = rand(1, 3);

                $bundle_ids[] = $id_bundle_random;
                
                $created_date = new Carbon($faker->dateTimeBetween('-45days', 'now'));
                $bundle = Bundle::findOrFail($id_bundle_random);
                
                $expired_date = Carbon::parse($created_date)->addDays($bundle['duration']);
                array_push($bundle_expired_dates, ['created_date' => $created_date, 'expired_date' => $expired_date]);
            }

            $bundle_expire_array = array_combine($bundle_ids, $bundle_expired_dates);

            $new_user->bundles()->sync($bundle_expire_array);
        }
    }

    protected function getFreeSlugFromTitle($name) {
        // Assegnare lo slag
        $slug_to_save = Str::slug($name, '-');
        $slug_base = $slug_to_save;
        // Verificare se lo slag esiste nel database
        $existing_slug_user = User::where('slug', '=', $slug_to_save)->first();

        // Finchè non si trova uno slag libero, si appende un numero allo slag base -1, -2, ecc...
        $counter = 1;
        while($existing_slug_user) {
            // Si crea un nuovo slag con $counter
            $slug_to_save = $slug_base . '-' . $counter;

            // Verificare se lo slag esiste nel database
            $existing_slug_user = User::where('slug', '=', $slug_to_save)->first();

            $counter++;
        }

        return $slug_to_save;
    }
}