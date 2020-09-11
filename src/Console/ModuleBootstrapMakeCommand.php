<?php

namespace An5dy\LaravelAdminModules\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class ModuleBootstrapMakeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:module:bootstrap {module}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new bootstrap.';

    /**
     * Module name.
     *
     * @var string
     */
    protected $moduleName = '';

    /**
     * Install directory.
     *
     * @var string
     */
    protected $directory = '';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->moduleName = $this->getModuleName();
        $this->directory = app_path($this->moduleName);

        $this->createBootstrapFile();
        $this->createModuleBootstrapMiddleware();
    }

    /**
     * Create bootstrap file.
     *
     * @return void
     */
    protected function createBootstrapFile()
    {
        $file = $this->directory . DIRECTORY_SEPARATOR . 'bootstrap.php';

        $stub = $this->getStub('bootstrap');
        $this->laravel['files']->put($file, $stub);

        $this->line('<info>Bootstrap file was created:</info> ' . str_replace(base_path(), '', $file));
    }

    /**
     * Create module bootstrap middleware.
     *
     * @return void
     */
    protected function createModuleBootstrapMiddleware()
    {
        $this->makeDir('Middleware');

        $file = $this->directory . DIRECTORY_SEPARATOR . 'Middleware' . DIRECTORY_SEPARATOR . 'ModuleBootstrap.php';

        $stub = str_replace([
            'DummyNamespace',
        ], [
            module_namespace($this->moduleName, 'Middleware'),
        ], $this->getStub('ModuleBootstrap'));

        $this->laravel['files']->put($file, $stub);

        $this->line('<info>Module bootstrap middleware file was created:</info> ' . str_replace(base_path(), '', $file));
    }

    /**
     * Get module name.
     *
     * @return array|bool|string|null
     */
    protected function getModuleName()
    {
        return Str::ucfirst($this->argument('module'));
    }

    /**
     * Get stub contents.
     *
     * @param $name
     *
     * @return mixed
     */
    protected function getStub($name): string
    {
        return $this->laravel['files']->get(__DIR__ . DIRECTORY_SEPARATOR . 'stubs' . DIRECTORY_SEPARATOR . $name . '.stub');
    }

    /**
     * Make new directory.
     *
     * @param string $path
     */
    protected function makeDir($path = '')
    {
        $this->laravel['files']->makeDirectory($this->directory . DIRECTORY_SEPARATOR . $path, 0755, true, true);
    }
}