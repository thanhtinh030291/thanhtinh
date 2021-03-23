<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Console\Commands\AuthPermissionCommand;
use App\Console\Commands\GetCPS;
use App\Console\Commands\GetHBS;
use App\Console\Commands\GetRenewPayment;
use App\Console\Commands\UpdateFile;
use App\Console\Commands\UploadMfile;
use App\Console\Commands\UploadMfileAuto;
class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        AuthPermissionCommand::class,
        GetCPS::class,
        GetHBS::class,
        GetRenewPayment::class,
        UpdateFile::class,
        UploadMfile::class,
        UploadMfileAuto::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();command:GetCPS
        $schedule->command('command:GetCPS')->everyFiveMinutes();
        $schedule->command('command:GetHBS')->everyFiveMinutes();
        $schedule->command('command:GetRenewPayment')->everyFiveMinutes();
        $schedule->command('command:UpdateFile')->everyFiveMinutes();
        $schedule->command('command:CheckFinishAndPay')->everyFiveMinutes();
        $schedule->command('command:UploadMfile')->dailyAt('23:00');
        $schedule->command('command:UploadMfileAuto')->hourly();
        
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
