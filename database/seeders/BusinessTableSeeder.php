<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class BusinessTableSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();

        for ($d = 1; $d < 3; $d++) {
            for ($i = 0; $i < 3; $i++ ) {
                \App\Model\Business::create([
                    'user_id'       => $d,
                    'name'          => $faker->company,
                    'email'         => $faker->companyEmail,
                    'phone'         => $faker->phoneNumber,
                    'social'        => [
                        ['type' => 'facebook', 'value' => 'https://facebook.com/imelar'],
                        ['type' => 'twitter', 'value' => 'https://twitter.com/imelar']
                    ],
                    'address'       => $faker->streetAddress,
                    'lga'           => $faker->countryCode,
                    'state'         => 'Lagos',
                    'country'       => $faker->country,
                    'description'   => $faker->realText(),
                    'category'      => 'Fashion',
                    'sub_category'  => $faker->randomElement(['Hair', 'Clothes', 'Footwear', 'Makeup Kit']),
                    'type'          => $faker->randomElement(['WHOLESALER', 'RETAILER'])
                ]);
            }
        }


        \App\Model\BusinessMessage::updateOrCreate(['type' => 'BIRTHDAY'],
            ['business_id' => 1, 'message' => 'Wishing a cherished customer and friend a very happy birthday celebration. Thank you for contributing the growth and success of the business']);

        \App\Model\BusinessMessage::updateOrCreate(['type' => 'BIRTHDAY'],
            ['business_id' => 6, 'message' => 'Wishing a cherished customer and friend a very happy birthday celebration. Thank you for contributing the growth and success of the business']);
    }
}
