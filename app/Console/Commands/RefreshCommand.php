<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class RefreshCommand extends Command
{
    protected $signature = 'dev:refresh';

    protected $description = 'Project refresh';

    public function handle(): int
    {
        if (app()->isProduction()) {
            return self::FAILURE;
        }

        Storage::deleteDirectory('images/products');
        Storage::deleteDirectory('images/brands');

        Cache::flush();

        $this->call('migrate:fresh');
        $this->call('db:seed');

        return self::SUCCESS;
    }
}
