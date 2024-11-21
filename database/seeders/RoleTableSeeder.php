<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        \Spatie\Permission\Models\Role::updateOrCreate(['name' => 'ADMIN']);
        \Spatie\Permission\Models\Role::updateOrCreate(['name' => 'USER']);
    }
}
