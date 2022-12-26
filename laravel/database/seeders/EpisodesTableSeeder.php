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
        //Chroniques économiques
        for ($i = 1; $i <= 37; $i++) {
            DB::table('episodes')->insert([
                'podcast_id' => 1,
                'no' => $i,
                'title' => 'Chroniques économiques épisode ' . $i,
                'path' => storage_path('/audio/podcasts/chroniques-economiques/' . $i)
            ]);
        }

        //Digitime saison 1
        for ($i = 1; $i < 5; $i++) {
            DB::table('episodes')->insert([
                'podcast_id' => 2,
                'no' => $i,
                'title' => 'Digitime épisode ' . $i,
                'path' => storage_path('/audio/podcasts/digitime/' . $i)


            ]);
        }

        //Digitime saison 2
        for ($i = 5; $i < 14; $i++) {
            DB::table('episodes')->insert([
                'podcast_id' => 2,
                'no' => $i,
                'title' => 'Digitime épisode ' . $i,
                'path' => storage_path('/audio/podcasts/digitime/' . $i)

            ]);
        }

        //Anbu Savana
        for ($i = 1; $i < 100; $i++) {
            DB::table('episodes')->insert([
                'podcast_id' => 3,
                'no' => $i,
                'title' => 'Anbu Savana épisode ' . $i,
                'path' => storage_path('/audio/podcasts/anbu-savana/' . $i)

            ]);
        }
    }
}