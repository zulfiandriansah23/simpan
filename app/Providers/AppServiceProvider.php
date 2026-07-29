<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Admin\BarangModel;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
         $stokMenipis = BarangModel::where('barang_stok', '<=', 100)
        ->orderBy('barang_stok', 'ASC')
        ->get();

    View::share('stokMenipis', $stokMenipis);
    View::share('jumlahNotifikasi', $stokMenipis->count());
        if(env(key:'APP_ENV') !== 'local'){
            URL::forceScheme( scheme: 'https' );
        }
    }
}
