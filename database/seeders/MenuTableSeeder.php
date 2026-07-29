<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
{
    DB::table('tbl_menu')->insert([
        [
            'menu_id' => '1667444041',
            'menu_judul' => 'Dashboard',
            'menu_slug' => 'dashboard',
            'menu_icon' => 'home',
            'menu_redirect' => '/dashboard',
            'menu_sort' => 1,
            'menu_type' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ],

        [
            'menu_id' => '1667444042',
            'menu_judul' => 'Barang Masuk',
            'menu_slug' => 'barang-masuk',
            'menu_icon' => 'inbox',
            'menu_redirect' => '/barang-masuk',
            'menu_sort' => 2,
            'menu_type' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ],

        [
            'menu_id' => '1667444043',
            'menu_judul' => 'Barang Keluar',
            'menu_slug' => 'barang-keluar',
            'menu_icon' => 'shopping-cart',
            'menu_redirect' => '/barang-keluar',
            'menu_sort' => 3,
            'menu_type' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]
    ]);
}
}
