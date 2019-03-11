<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Admin',
            'username' => 'admin',
            'role' => 1,
            'email' => 'admin@admin.com',
            'password' => bcrypt('111111'),
            'address' => 'Dhaka',
            'remember_token' => str_random(10),
            'email_verified_at' => now()

        ]);
    }
}
