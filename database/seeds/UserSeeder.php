<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Generator as Faker;
use App\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        // admin
        $user = new User;
        $user->name = 'Admin';
        $user->email = 'admin@localhost.com';
        $user->password = Hash::make('password');
        $user->save();

        // random users
        for ($i=0; $i < 2; $i++) {
            $user = new User;
            $user->name = $faker->firstName() . ' ' . $faker->lastName();
            $user->email = $faker->email();
            $user->password = Hash::make('password');
            $user->save();
        }
    }
}
