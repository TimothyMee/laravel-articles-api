<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;

class CreateDefaultUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create Default user for login';

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
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Creating Default User');
        $user = new User();
        $newUser = $user->create(config('default.user'));
        $this->info('Created Default User'. $newUser->name);        
    }
}
