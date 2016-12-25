<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LinksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('links')->insert([
            'link_name' => str_random(10),
            'link_title' => str_random(10),
            'link_url' => 'http://' . str_random(10) . '.com',
            'link_order' => mt_rand(1, 20)
        ]);
    }
}
