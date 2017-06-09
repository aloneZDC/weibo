<?php

/*
 * This file is part of the Antvel Shop package.
 *
 * (c) Gustavo Ocanto <gustavoocanto@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace Tests;

use App\Exceptions\Handler;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

	protected function setUp()
    {
        parent::setUp();
        // $this->disableExceptionHandling();
    }

    /**
     * Disables the Laravel exception handling.
     *
     * @author @adamwathan <https://gist.github.com/adamwathan/125847c7e3f16b88fa33a9f8b42333da>
     * @return void
     */
    protected function disableExceptionHandling()
    {
        $this->oldExceptionHandler = $this->app->make(ExceptionHandler::class);

        $this->app->instance(ExceptionHandler::class, new class extends Handler {
            public function __construct() {}
            public function report(\Exception $e) {}
            public function render($request, \Exception $e) {
                throw $e;
            }
        });
    }

    /**
     * Enables the Laravel exception handling.
     *
     * @author @adamwathan <https://gist.github.com/adamwathan/125847c7e3f16b88fa33a9f8b42333da>
     * @return void
     */
    protected function withExceptionHandling()
    {
        $this->app->instance(ExceptionHandler::class, $this->oldExceptionHandler);

        return $this;
    }

    /**
     * Swap the storage folder for the given path.
     *
     * @param  string $path
     *
     * @return void
     */
    protected function swapStorageFolder($path = null)
    {
        $path = $path ?: storage_path('framework/testing/disks');

        $this->app->make('config')->set(
            'filesystems.disks.local.root', $path
        );
    }
}
