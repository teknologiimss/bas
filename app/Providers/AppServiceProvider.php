<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

use App\Models\Monitoring;
use Carbon\Carbon;

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
        // =========================
        // FORMAT RUPIAH
        // =========================
        Blade::directive('rupiah', function ($expression) {
            return "Rp. <?php echo number_format($expression,0,',','.'); ?>";
        });

        // =========================
        // NOTIFIKASI NAVBAR MRO
        // =========================
        View::composer('*', function ($view) {

            $today = Carbon::today();

            $notifications = Monitoring::all()->filter(function ($item) use ($today) {

                // Pastikan tanggal ada
                if (!$item->tanggal_selesai_kontrak) {
                    return false;
                }

                $selesai = Carbon::parse($item->tanggal_selesai_kontrak);

                // Selisih hari
                $sisa = $today->diffInDays($selesai, false);

                // tampil jika expired atau H-7
                return $sisa <= 7;
            });

            $view->with('notifications', $notifications);
        });
    }
}