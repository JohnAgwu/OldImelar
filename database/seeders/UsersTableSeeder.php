<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        $user  = \App\User::updateOrCreate(
            ['email' => 'canaanetai@gmail.com','phone' => '0816324071'],
            [
                'name'      => 'Canaan Etai',
                'dob'       => '1990-07-20',
                'gender'    => 'MALE',
                'password'  => bcrypt('canaan55*')
            ]
        );

        $user2  = \App\User::updateOrCreate(
            ['email' => 'admin@imelar.com','phone' => '07067028318'],
            [
                'name'      => 'John Agwu',
                'dob'       => '1980-02-21',
                'gender'    => 'MALE',
                'password'  => bcrypt('imelar123*')
            ]
        );

        $user->assignRole('USER');
        $user2->assignRole('USER');
        $user->markEmailAsVerified();
        $user2->markEmailAsVerified();
    }
}
