<?php

namespace An5dy\LaravelAdminModules\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class ModuleMakeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:module:make {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new module.';

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

        $this->initModuleDirectory();
    }

    /**
     * Initialize the module directory.
     *
     * @return void
     */
    protected function initModuleDirectory()
    {
        $this->directory = app_path($this->moduleName);

        if (is_dir($this->directory)) {
            $this->line("<error>{$this->directory} directory already exists !</error> ");

            return;
        }

        $this->makeDir(DIRECTORY_SEPARATOR);
        $this->line('<info>Module directory was created:</info> ' . str_replace(base_path(), '', $this->directory));

        $this->makeDir('Controllers');
        $this->makeDir('Models');

        $this->createServiceProvider();
        $this->createRoutesFile();
    }

    /**
     * Create service provider file.
     *
     * @return void
     */
    protected function createServiceProvider()
    {
        $this->makeDir('Providers');

        $className = $this->moduleName . 'ServiceProvider';

        $file = $this->directory . DIRECTORY_SEPARATOR . 'Providers' . DIRECTORY_SEPARATOR . $className . '.php';

        $stub = str_replace([
            'DummyNamespace',
            'DummyClass',
            'DummyModule',
        ], [
            module_namespace($this->moduleName, 'Providers'),
            $className,
            $this->moduleName,
        ], $this->getStub('provider.module'));

        $this->laravel['files']->put($file, $stub);

        $this->line('<info>Service provider file was created:</info> ' . str_replace(base_path(), '', $file));
    }

    /**
     * Create routes file.
     *
     * @return void
     */
    protected function createRoutesFile()
    {
        $file = $this->directory . DIRECTORY_SEPARATOR . 'routes.php';

        $stub = str_replace([
            'DummyAs',
            'DummyModule',
            'DummyNamespace',
        ], [
            Str::lower($this->moduleName),
            $this->moduleName,
            module_namespace($this->moduleName, 'Controllers')
        ], $this->getStub('routes'));

        $this->laravel['files']->put($file, $stub);

        $this->line('<info>Routes file was created:</info> ' . str_replace(base_path(), '', $file));
    }

    /**
     * Get module name.
     *
     * @return array|bool|string|null
     */
    protected function getModuleName()
    {
        return Str::ucfirst($this->argument('name'));
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