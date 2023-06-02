<?php

namespace App\Providers;

use App\Storage\DatabaseStorage;
use App\Storage\StorageInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(StorageInterface::class, function ($app) {
            // for now, we only have the DatabaseStorage
            return new DatabaseStorage();
        });
    }
}

