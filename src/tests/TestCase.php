<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;




abstract class TestCase extends BaseTestCase
{
    

    protected function setUp(): void
    {
        parent::setUp();

        // Register the component for tests
        $this->app->register(\App\Providers\AppServiceProvider::class);
        $this->app->register(\App\Providers\VoltServiceProvider::class);
    }
     
}
