<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class InstallApp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install Application';

    public function handle()
    {
        $this->info('Install App..........');
        $this->call('migrate:fresh');
        $this->call('db:seed');
        $this->call('passport:install' , ['--force' => '--force']);
        $this->info('App installed successfully!');

    }
}
