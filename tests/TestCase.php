<?php

namespace Josezenem\Slugidable\Tests;

use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');

        $migration = include __DIR__.'/../database/migrations/create_slugidable_table.php.stub';
        $migration->up();
    }
}
