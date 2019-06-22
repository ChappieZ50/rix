<?php

use Illuminate\Database\Seeder;

class PostSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('rix_posts')->insert([
            'title'           => 'Post',
            'slug'            => 'post',
            'content'         => 'asdasd',
            'summary'         => 'asdasd',
            'featured_image'  => 1,
            'seo_title'       => 'asd',
            'seo_description' => 'asd',
            'author_id'       => 1,
            'readable_date'   => \App\Helpers\Helper::readableDateFormat(),
        ]);
    }
}
