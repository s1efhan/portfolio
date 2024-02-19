<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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
            'name' => 'Stefan Theißen',
            'email' => 'stefan.theissen@mail.de',
            'email_verified_at' => now(),
            'password' => '$2y$12$gmY.NYUSuLUM9.syfM06ge2AyG0ez9LLqG5FAHrgS7v6ykAHjQ1Ni',
            'language' => 'de',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
