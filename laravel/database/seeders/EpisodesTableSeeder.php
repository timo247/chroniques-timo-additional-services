<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class EpisodesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // //Chroniques économiques
        // for ($i = 1; $i <= 37; $i++) {
        //     DB::table('episodes')->insert([
        //         'podcast_id' => 1,
        //         'no' => $i,
        //         'title' => 'Chroniques économiques épisode ' . $i,
        //         'path' => storage_path('/audio/podcasts/chroniques-economiques/' . $i),
        //         'description' => 'random description',
        //     ]);
        // }

        // //Digitime saison 1
        // for ($i = 1; $i < 5; $i++) {
        //     DB::table('episodes')->insert([
        //         'podcast_id' => 2,
        //         'no' => $i,
        //         'title' => 'Digitime épisode ' . $i,
        //         'path' => storage_path('/audio/podcasts/digitime/' . $i),
        //         'description' => 'random description',
        //     ]);
        // }

        // //Digitime saison 2
        // for ($i = 5; $i < 14; $i++) {
        //     DB::table('episodes')->insert([
        //         'podcast_id' => 2,
        //         'no' => $i,
        //         'title' => 'Digitime épisode ' . $i,
        //         'path' => storage_path('/audio/podcasts/digitime/' . $i),
        //         'description' => 'random description',
        //     ]);
        // }

        // //Anbu Savana
        // for ($i = 1; $i < 100; $i++) {
        //     DB::table('episodes')->insert([
        //         'podcast_id' => 3,
        //         'no' => $i,
        //         'title' => 'Anbu Savana épisode ' . $i,
        //         'path' => storage_path('/audio/podcasts/anbu-savana/' . $i),
        //         'description' => 'random description',
        //     ]);
        // }
        DB::table('episodes')->insert([
            "podcast_id" => 1,
            "no" => -41,
            "title" => "Title 1",
            "description" => "test",
            "created_at" => "2023-10-16T18:30:59.000000Z",
            "updated_at" => "2023-10-26T15:43:04.000000Z",
        ]);

        DB::table('episodes')->insert([
            "podcast_id" => 1,
            "no" => -41,
            "title" => "Title 2",
            "description" => "test",
            "created_at" => "2023-10-17T11:51:59.000000Z",
            "updated_at" => "2023-10-26T15:43:04.000000Z",
        ]);

        DB::table('episodes')->insert([
            "podcast_id" => 1,
            "no" => 41,
            "title" => "Title 3",
            "description" => "test42",
            "created_at" => "2023-10-26T15:42:31.000000Z",
            "updated_at" => "2023-10-26T15:43:04.000000Z",
        ]);
    }
}
