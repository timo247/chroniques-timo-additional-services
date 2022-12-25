<?php

namespace Database\Seeders;

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
        $this->call(UsersTableSeeder::class);
        $this->call(ArticlesTableSeeder::class);
        $this->call(PodcastsTableSeeder::class);
        $this->call(EpisodesTableSeeder::class);
        //$this->call(CommentairesTableSeeder::class);
    }
}