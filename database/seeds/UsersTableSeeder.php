<?php

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
        \Illuminate\Support\Facades\DB::table('users')->insert([
            'name' => 'Martua Nasution',
            'email' => 'marithonst@gmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('Bootstrap321@'), // password
            'remember_token' => \Illuminate\Support\Str::random(10),
            'status' => 1
        ]);
    }
}
