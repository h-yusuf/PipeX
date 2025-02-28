<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'admin',
            'username' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('secret'),
            'role_id' => '1'
        ]);
        User::create([
            'name' => 'manager',
            'username' => 'manager',
            'email' => 'manager@gmail.com',
            'password' => bcrypt('secret'),
            'role_id' => '2'
        ]);

        User::create([
            'name' => 'operator',
            'username' => 'operator',
            'email' => 'operator@gmail.com',
            'password' => bcrypt('secret'),
            'role_id' => '3'
        ]);

    }
}
