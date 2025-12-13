<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // Jalankan scraper Galeri Gold setiap hari jam 10:00 pagi
        $schedule->command('scrape:galeri-gold')
            ->dailyAt('10:00')
            ->timezone('Asia/Jakarta')
            ->onSuccess(function () {
                \Illuminate\Support\Facades\Log::info('Scraper Galeri Gold berhasil dijalankan');
            })
            ->onFailure(function () {
                \Illuminate\Support\Facades\Log::error('Scraper Galeri Gold gagal dijalankan');
            });
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
