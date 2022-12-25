<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PodcastsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Chroniques économiques
        DB::table('podcasts')->insert([
            "title" => "Chroniques économiques"
        ]);
        
        //Digitime
        DB::table('podcasts')->insert([
            "title" => "Digitime"
        ]);

         //Anbu Savana
         DB::table('podcasts')->insert([
            "title" => "Anbu Savana"
        ]);
    }
}
