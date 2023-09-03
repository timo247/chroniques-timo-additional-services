<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TagsTableSeeder extends Seeder
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
            'Échec',
            'Sociabilité',
            'Générosité',
            'Courage',
            'Avarice',
            'Stress',
            'Travail',
            'Réussite',
            'Oisiveté',
            'Repos',
            'Intelligence',
            'Ignorance',
            'Simplicité',
            'Pureté',
            'Vulgarité',
        ];

        foreach ($themes as $theme) {
            $lowCaseTheme =  mb_strtolower($theme, 'UTF-8');

            // Remplacer les caractères spéciaux avec accent
            $cleanedCaseTheme = str_replace(
                array('à', 'á', 'â', 'ä', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ñ', 'ò', 'ó', 'ô', 'ö', 'ù', 'ú', 'û', 'ü'),
                array('a', 'a', 'a', 'a', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'n', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u'),
                $lowCaseTheme
            );
            DB::table('tags')->insert([
                'value' => $theme,
                'name' => $cleanedCaseTheme
            ]);
        }
    }
}
