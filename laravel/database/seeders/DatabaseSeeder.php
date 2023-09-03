<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\TagsTableSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(PodcastsTableSeeder::class);
        $this->call(EpisodesTableSeeder::class);
        $this->call(CharactersTableSeeder::class);
        $this->call(TagsTableSeeder::class);
        //$this->call(CommentairesTableSeeder::class);
    }
}
