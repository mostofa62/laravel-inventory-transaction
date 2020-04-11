<?php

use Illuminate\Database\Seeder;

class ItemTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('items')->insert([
            ['name' => 'Fan'],
            ['name' => 'Light'],
            ['name' => 'Switch'],
            ['name' => 'MultiPlug'],
            ['name' => 'Cable'],            
        ]);
    }
}
