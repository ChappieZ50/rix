<?php

use Illuminate\Database\Seeder;

class CommentSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 3; $i++) {
            DB::table('rix_comments')->insert([
                'name'          => $i . 'Uğur Tosun',
                'email'         => $i . 'chappie@gmail.com',
                'comment'       => $i . 'asdasd',
                'ip'            => Request::ip(),
                'post_id'       => 1,
                'user_id'       => $i === 1 ? $i : null,
                'readable_date' => \App\Helpers\Helper::readableDateFormat(),
            ]);
        }
    }
}
