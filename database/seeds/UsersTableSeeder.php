<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        factory(App\User::class, 3)->create()->each(function($u) use ($faker) {
            $u->first_name = $faker->firstName;
	        $u->last_name = $faker->lastName;
            $u->profile->date_of_birth = $faker->dateTimeBetween('-30 year', '-18 year');
            $u->profile->latitude    = $faker->randomFloat(6, 47, 49);
            $u->profile->longitude    = $faker->randomFloat(6, 4, 6);
	    });
    }
}
