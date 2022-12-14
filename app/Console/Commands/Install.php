<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\{Artisan,Config,DB};
use \App\Models\Admin\Company;

class Install extends Command
{
    /**
    * The name and signature of the console command.
    *
    * @var string
    */
    protected $signature = 'system:install';
    
    /**
    * The console command description.
    *
    * @var string
    */
    protected $description = 'Installs the advertising campaigns system';
    
    /**
    * Execute the console command.
    *
    * @return int
    */
    public function handle()
    {
        $this->fresh();
    }
    
    public function fresh(){

        $this->comment('Generating Keys...');
        Artisan::call("key:generate");
        $this->info('Keys Generated!');
        
        $this->comment('Generating Passport Keys...');
        Artisan::call("passport:keys");
        $this->info('Passport Keys Generated!');
        
        $this->comment('Refreshing Database...');
        Artisan::call("migrate:fresh --seed");
        $this->info('Database Refreshed!');
        
        $this->comment('Preparing Laravel/Passport...');
        Artisan::call("passport:install");
        $this->info('Laravel/Passport Prepared!');
        
    }
}
