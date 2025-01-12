<?php

namespace App\Console;

use App\Models\User;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        // Add your commands here
    ];

    protected function schedule(Schedule $schedule)
    {
        // Schedule your commands here
        $schedule->command('backup:run')->daily(); // example for daily backup

    }


    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
