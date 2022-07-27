<?php

namespace App\Console\Commands;

use App\Http\Controllers\ValidatorController;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class UpdateValidators extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:validators';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update validators Info from Kusama telemetry';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     * In order to automatically update validators info from Kusama telemetry service,
     * you need add this command to your crontab:
     * * * * * * cd /var/www/html/kusama && /usr/local/bin/php artisan schedule:run >> /dev/null  2>&1
     *  and add it to /var/www/html/kusama/app/Console/Kernel.php 
     * function schedule()
     * 
     * @return void
     */
    public function handle()
    {
        Log::channel('update')->info('Updating validators info...');
        $leaderboard = new ValidatorController();
        if ($leaderboard->updateValidators()) {
            Log::channel('update')->info('Validators info updated.');
        }else {
            Log::channel('update')->info('Validators are not updated. Error!!!');
        }
    }
}
