<?php

use App\Model\Format;
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
        Format::firstOrCreate(['name' => 'Commander']);
        Format::firstOrCreate(['name' => 'Brawl']);
    }
}
