<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Paola Jimenez',
            'phone' => 9617356286,
            'email' => 'paolaj@gmail.com',
            'profile' => 'ADMIN',
            'status' => 'ACTIVE',
            'password' => bcrypt('12345')
        ]);


        User::create([
            'name' => 'Adriana Jimenez',
            'phone' => 9618362745,
            'email' => 'adriana@gmail.com',
            'profile' => 'EMPLOYEE',
            'status' => 'ACTIVE',
            'password' => bcrypt('12345')
        ]);
    }
}
