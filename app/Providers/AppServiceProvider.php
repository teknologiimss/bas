<?php

namespace App\Providers;

use App\Models\Monitoring;
use Carbon\Carbon;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
        Paginator::useBootstrap();
        // =========================
        // FORMAT RUPIAH
        // =========================
        Blade::directive('rupiah', function ($expression) {
            return "Rp. <?php echo number_format($expression,0,',','.'); ?>";
        });

        // =========================
        // NOTIFIKASI NAVBAR MRO
        // =========================
        // View::composer('*', function ($view) {

        //     $today = Carbon::today();

        //     $notifications = Monitoring::all()->filter(function ($item) use ($today) {

        //         // Pastikan tanggal ada
        //         if (!$item->tanggal_selesai_kontrak) {
        //             return false;
        //         }

        //         $selesai = Carbon::parse($item->tanggal_selesai_kontrak);

        //         // Selisih hari
        //         $sisa = $today->diffInDays($selesai, false);

        //         // tampil jika expired atau H-7
        //         return $sisa <= 7;
        //     });

        //     $view->with('notifications', $notifications);
        // });

        View::composer('*', function ($view) {
            if ($view->offsetExists('notifications')) {
                return;
            }

            $today = Carbon::today();

            $notifications = Monitoring::all()->filter(function ($item) use ($today) {
                // Jangan tampilkan jika status sudah Closed
                if (strtolower((string) $item->status) === 'closed') {
                    return false;
                }

                // Pastikan tanggal ada
                if (!$item->tanggal_selesai_kontrak) {
                    return false;
                }

                $selesai = Carbon::parse($item->tanggal_selesai_kontrak)->startOfDay();
                $sisa = (int) $today->diffInDays($selesai, false);

                // Tampil jika expired atau H-7
                return $sisa <= 7;
            })->values();

            $view->with('notifications', $notifications);
        });
    }
}
