<?php

/*
 * This file is part of the Antvel e-commerce.
 *
 * (c) Gustavo Ocanto <gustavoocanto@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class RenameComposerFile extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'antvel:composer {using?} {--dev : Set composer to work in development mode. }';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update composer to work either in development or in production.';

    /**
     * The laravel filesystem component.
     *
     * @var Filesystem
     */
    protected $filesystem = null;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Filesystem $filesystem)
    {
        parent::__construct();

        $this->filesystem = $filesystem;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if ($this->argument('using')) {
            return $this->fileInUse();
        }

        if ($this->option('dev')) {
            return $this->development();
        }

        return $this->production();
    }

    /**
     * Rename the composer file to work in development mode.
     *
     * @return void
     */
    protected function development()
    {
        if ($this->filesystem->isFile($this->composerPrdFile())) {
            $this->error('Whoops.');
            $this->info('You are in development mode already!');
            $this->comment('Change to production mode to perform this action again.');

            return;
        }

        $this->filesystem->move(
            $this->composerFile(), $this->composerPrdFile()
        );

        $this->filesystem->move(
            $this->composerDevFile(), $this->composerFile()
        );

        $this->info('The composer file was successful renamed!');
    }

    /**
     * Rename the composer file to work in production mode.
     *
     * @return void
     */
    protected function production()
    {
        if ($this->filesystem->isFile($this->composerDevFile())) {
            $this->error('Whoops.');
            $this->info('You are in production mode already!');
            $this->comment('Change to development mode to perform this action again.');

            return;
        }

        $this->filesystem->move(
            $this->composerFile(), $this->composerDevFile()
        );

        $this->filesystem->move(
            $this->composerPrdFile(), $this->composerFile()
        );

        $this->info('The composer file was successful renamed!');
    }

    /**
     * Shows what uses is set for the composer file.
     *
     * @return void
     */
    protected function fileInUse()
    {
        if ($this->filesystem->isFile($this->composerPrdFile())) {
            $this->comment('The composer file is set to run as development mode!');

            return;
        }

        $this->comment('The composer file is set to run as production mode!');
    }

    /**
     * Returns the composer file.
     *
     * @return string
     */
    protected function composerFile()
    {
        return base_path() . '/composer.json';
    }

    /**
     * Returns the composer file for production.
     *
     * @return string
     */
    protected function composerPrdFile()
    {
        return base_path() . '/composer.json.prd';
    }

    /**
     * Returns the composer file for development.
     *
     * @return string
     */
    protected function composerDevFile()
    {
        return base_path() . '/composer.json.dev';
    }
}
