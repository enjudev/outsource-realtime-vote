<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Menu;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Menu::create([
            'name' => 'Menu 1',
            'url' => '/menu1',
            'parent_id' => 0,
            'ordering' => 1,
            'status' => 1,
        ]);

        Menu::create([
            'name' => 'Menu 2',
            'url' => '/menu2',
            'parent_id' => 0,
            'ordering' => 2,
            'status' => 1,
        ]);

        // Các menu con
        Menu::create([
            'name' => 'Submenu 1',
            'url' => '/submenu1',
            'parent_id' => 1,
            'ordering' => 1,
            'status' => 1,
        ]);

        Menu::create([
            'name' => 'Submenu 2',
            'url' => '/submenu2',
            'parent_id' => 1,
            'ordering' => 2,
            'status' => 1,
        ]);
    }
}
