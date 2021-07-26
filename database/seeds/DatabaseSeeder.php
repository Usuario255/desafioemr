<?php

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
        // $this->call(UserSeeder::class);

        DB::table('users')->insert([
            'name' => 'Vinicius',
            'email' => 'vinicius@desafioemr.com.br',
            'password' => bcrypt('abc123456'),
        ]);

        DB::table('users')->insert([
            'name' => 'Thiago Batista',
            'email' => 'thiago@desafioemr.com.br',
            'password' => bcrypt('abc123456'),
        ]);
    }
}
