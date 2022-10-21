<?php

use Illuminate\Database\Seeder;
use App\Specialization;
use Illuminate\Support\Str;

class SpecializationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $specializations = [
            'cardiologia',
            'neurologia',
            'ortopedia',
            'andrologia',
            'urologia',
            'dermatologia',
            'oculistica',
            'proctologia'
        ];

        foreach($specializations as $specialization) {
            $new_specialization = new Specialization();

            $new_specialization->name = $specialization;
            $new_specialization->slug = Str::slug($new_specialization->name, '-');
            $new_specialization->save();
        }
    }
}
