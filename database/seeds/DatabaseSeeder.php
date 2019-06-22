<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeed::class,
            ImageSeed::class,
            PostSeed::class,
            CommentSeed::class,
            MessageSeed::class,
        ]);
    }
}
