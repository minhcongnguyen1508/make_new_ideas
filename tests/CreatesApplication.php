<?php

namespace Tests;

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\Facades\Artisan;

trait CreatesApplication 
{
    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    // public function createApplication()
    // {
    //     $app = require __DIR__.'/../bootstrap/app.php';

    //     $app->make(Kernel::class)->bootstrap();

    //     return $app;
    // }
    public function createApplication()
    {
        putenv('DB_DEFAULT=mysql_test');

        $app = require __DIR__ . '/../bootstrap/app.php';

        $app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

        return $app;
    }
}
