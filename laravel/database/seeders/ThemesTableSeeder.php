<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ThemesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $themes = [
            'Justice',
            'Gloire',
            'Pouvoir',
            'Gouvernance',
            'Argent',
            'Amour',
            'Ordre',
            'Nature',
            'Éloquence',
            'Joie',
            'Colère',
            'Équilibre',
            'Sagesse',
            'Technologie',
            'Réussite',
            'Écherc',
            'Sociabilité',
            'Générosité',
            'Courage',
            'Avarice'
        ];

        foreach ($themes as $theme) {
            DB::table('themes')->insert([
                'value' => $theme
            ]);
        }
    }
}
