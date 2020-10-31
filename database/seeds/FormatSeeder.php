<?php

use Illuminate\Database\Seeder;

class FormatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Model\Format::create(['name' => 'Commander']);
        \App\Model\Format::create(['name' => 'Brawl']);
    }
}
