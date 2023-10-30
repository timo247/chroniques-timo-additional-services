<?php

namespace Database\Seeders;

use App\Models\Episode;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EpisodesTagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Affiliate 3 tags per seeded episode
     */
    public function run(): void
    {
        $episodes = Episode::get();
        $tagId = 1;
        foreach ($episodes as $episode) {
            for ($i = $tagId; $i < $tagId + 3; $i++) {
                $episode->tags()->attach($i + 1);
            }
            $tagId += 3;
        }
    }
}
