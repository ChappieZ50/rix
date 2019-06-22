<?php

use Illuminate\Database\Seeder;

class ImageSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('rix_gallery')->insert([
            'image_name'           => 'asda',
            'image_data'            => json_encode(['asd']),
        ]);
    }
}
