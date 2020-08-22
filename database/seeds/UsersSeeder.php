<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'middle_name' => '',
            'date_of_birth' => '1993-8-11',
            'email' => 'admin@bilinguar.systems',
            'password' => Hash::make('password'),
            'role' => 'admin'
        ]);

    }
}
