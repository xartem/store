<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class InstallCommand extends Command
{
    protected $signature = 'install';

    protected $description = 'Project installation';

    public function handle(): int
    {
        $this->call('storage:link');
        $this->call('migrate');

        return self::SUCCESS;
    }
}
