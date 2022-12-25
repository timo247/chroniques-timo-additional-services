<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->delete();
        for ($i = 1; $i <= 10; $i++) {
            DB::table('users')->insert([
                'name' => 'Nom' . $i,
                'email' => 'email' . $i . '@gmx.ch',
                'password' => Hash::make('password' . $i),
                'admin' => false
            ]);
        }
        DB::table('users')->where('id', '=', 3)->update(['admin' => true]);
    }

    /*Make user3 admin:
    App\Models\User::where('id', 3)->update(['admin' => true]);
    */
}