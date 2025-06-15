<?php

namespace App\Console;

use App\Jobs\UpdateMonthlySaldo;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule): void
    {
        $schedule->job(new UpdateMonthlySaldo(now()->month, now()->year))
            ->monthlyOn(1, '00:00')
            ->runInBackground();
    }

    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');
        require base_path('routes/console.php');
    }
}