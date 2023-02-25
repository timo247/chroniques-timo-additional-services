<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CharactersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $characters = [
            'Yatus le gorille',
            'Yata le gorille',
            'Makamba le singe',
            'Athiyya l\'éléphante',
            'Yamaka la tortue',
            'Bob le tapir',
            'Arthur le serpent',
            'Ania la mouette',
            'Maepatou l\'épervier',
            'Gregory le castor',
            'Gainde le lion',
            'Bouki l\'hyène',
            'Lucilia la luciole',
            'George le moineau',
            'Geoffrey le rhinocéros',
            'Rigobert le phacochère',
            'Nicomaque le mulot',
            'Famba la biche',
            'Aritothélès le bouc'
        ];

        foreach ($characters as $char) {
            DB::table('characters')->insert([
                'name' => $char
            ]);
        }
    }
}
