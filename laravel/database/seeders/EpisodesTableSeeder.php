<?php

namespace Database\Seeders;

use App\Http\Controllers\BaseController;
use App\Models\Tag;
use App\Models\Episode;
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

        $ep = Episode::create([
            "podcast_id" => 3,
            "no" => 303,
            "title" => "Le contexte dans lequel on s'exprime",
            "spotify_uri" => "0Hv0HTxBu70NPnEGQgenEP",
            "description" => "test"
        ]);
        $this->manageTagCreationAndAttachment(['communication', 'interprétation'], $ep);

        $ep = Episode::create([
            "podcast_id" => 3,
            "no" => 302,
            "title" => "Détruire la nature par l'action humaine",
            "spotify_uri" => "7MdwFbMrjrGLZCd1QFJu9c",
            "description" => "test"
        ]);
        $this->manageTagCreationAndAttachment(['nature', 'communication'], $ep);

        $ep = Episode::create([
            "podcast_id" => 3,
            "no" => 301,
            "title" => "Le courage d'entreprendre",
            "spotify_uri" => "7aYypJ3cz4oQNMlzGnt0qK",
            "description" => "test"
        ]);
        $this->manageTagCreationAndAttachment(['adaptation', 'courage'], $ep);

        $ep = Episode::create([
            "podcast_id" => 3,
            "no" => 300,
            "title" => "Ce qu'il faut faire face à l'impermanence",
            "spotify_uri" => "4bF1ft92LFvtzLaWcDHYUo",
            "description" => "test"
        ]);
        $this->manageTagCreationAndAttachment(['générosité', 'constance'], $ep);
    }

    public function manageTagCreationAndAttachment($tagValues, $episode)
    {
        foreach ($tagValues as $tagValue) {
            $tag = Tag::firstOrCreate(['value' => $tagValue], ['name' => BaseController::cleanCaseString($tagValue)]);
            $episode->tags()->attach($tag->id);
        }
    }
}
