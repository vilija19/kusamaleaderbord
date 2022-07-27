<?php

namespace App\Console\Commands;

use App\Http\Controllers\ValidatorController;
use Illuminate\Console\Command;

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
     * 0 * * * * php artisan update:validators 2>&1
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Updating validators info...');
        $leaderboard = new ValidatorController();
        if ($leaderboard->updateValidators()) {
            $this->info('Validators info updated.');
        }else {
            $this->info('Validators are not updated. Error!!!');
        }
        return 0;
    }
}
