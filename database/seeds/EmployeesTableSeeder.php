<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmployeesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('employees')->insert([
            'name' => 'Employee',
            'desg_id' => 1,
            'dept_id' => 1,
            'email' => 'employee@employee.com',
            'phone' => '8801985632588',
            'username' => 'employee',
            'password' => bcrypt('111111'),
            'address' => 'Dhaka',
            'remember_token' => str_random(10),
        ]);
    }
}
