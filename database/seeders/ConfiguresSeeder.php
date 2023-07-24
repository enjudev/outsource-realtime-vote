<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ConfiguresSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('configures')->insert([
            ['configure_title' => 'test type text','configure_name' => 'type text','configure_type' => 'text','configure_publish' => '1','configure_ordering'=>'1','configure_value'=>''],
            ['configure_title' => 'test type textarea','configure_name' => 'type textarea','configure_type' => 'textarea','configure_publish' => '1','configure_ordering'=>'2','configure_value'=>''],
            ['configure_title' => 'test type image','configure_name' => 'type image','configure_type' => 'image','configure_publish' => '1','configure_ordering'=>'3','configure_value'=>''],
            ['configure_title' => 'test type switch','configure_name' => 'type switch','configure_type' => 'switch','configure_publish' => '1','configure_ordering'=>'4','configure_value'=>''],
        ]);
    }
}
