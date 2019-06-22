<?php

use Illuminate\Database\Seeder;

class MessageSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 3; $i++) {
            DB::table('rix_messages')->insert([
                'name'          => $i . 'Uğur Tosun',
                'email'         => $i . 'chappie@gmail.com',
                'subject'       => $i . 'asdasd',
                'ip'            => Request::ip(),
                'message'       => $i.'asdasdasdas',
                'readable_date' => \App\Helpers\Helper::readableDateFormat(),
            ]);
        }
    }
}
