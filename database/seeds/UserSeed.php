<?php

use Illuminate\Database\Seeder;

class UserSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('rix_users')->insert([
            'name' => 'Uğur Tosun',
            'username' => 'Chappie',
            'password' => Hash::make('123123'),
            'slug' => 'chappie',
            'email' => 'chappie@gmail.com',
            'role' => 'admin',
            'readable_date' => \App\Helpers\Helper::readableDateFormat(),
            'status' => 'ok',
            'user_data' => json_encode([])
        ]);
    }
}
