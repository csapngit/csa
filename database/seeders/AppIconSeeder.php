<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AppIconSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('app_icons')->insert([
        ['name' => 'Layers', 'path' => 'media/svg/icons/Design/Layers.svg', 'type' => 'Menu', 'created_at' => \Carbon\Carbon::now(), 'upload_by' => '1'],
        ['name' => 'Magic', 'path' => 'media/svg/icons/Design/Magic.svg', 'type' => 'Menu', 'created_at' => \Carbon\Carbon::now(), 'upload_by' => '1'],
        ['name' => 'Pencil', 'path' => 'media/svg/icons/Design/Pencil.svg', 'type' => 'Menu', 'created_at' => \Carbon\Carbon::now(), 'upload_by' => '1'],
        ['name' => 'Path', 'path' => 'media/svg/icons/Design/Path.svg', 'type' => 'Menu', 'created_at' => \Carbon\Carbon::now(), 'upload_by' => '1'],
        ['name' => 'Select', 'path' => 'media/svg/icons/Design/Select.svg', 'type' => 'Menu', 'created_at' => \Carbon\Carbon::now(), 'upload_by' => '1'],
    ]);
}
}
