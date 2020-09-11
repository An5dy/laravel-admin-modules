<?php

namespace An5dy\LaravelAdminModules\Console;

use Illuminate\Console\Command;

class ControllerMakeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:module:controller {module} {model}
        {--title=}
        {--stub= : Path to the custom stub file. }
        {--O|output}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new module controller class.';

    /**
     * The model name.
     *
     * @var string
     */
    protected $modelName;

    /**
     * The module name.
     *
     * @var string
     */
    protected $moduleName;

    /**
     * Execute the console command.
     *
     * @throws \ReflectionException
     */
    public function handle()
    {
        $this->modelName = $this->getModelName();
        $this->moduleName = $this->getModuleName();

        $this->call('admin:make', [
            'name' => $this->getControllerName(),
            '--model' => $this->getModelsNameSpace(),
            '--title' => $this->option('title'),
            '--stub' => $this->option('stub'),
            '--namespace' => $this->getNameSpace('Controllers'),
            '--output' => $this->option('output'),
        ]);
    }

    /**
     * Get module name.
     *
     * @return array|string|null
     */
    protected function getModuleName()
    {
        return $this->argument('module');
    }

    /**
     * Get model name.
     *
     * @return array|string|null
     */
    protected function getModelName()
    {
        return $this->argument('model');
    }

    /**
     * Get controller name.
     *
     * @return string
     * @throws \ReflectionException
     */
    protected function getControllerName()
    {
        $name = (new \ReflectionClass(module_namespace($this->moduleName, 'Models', $this->moduleName)))->getShortName();

        return $name . 'Controller';
    }

    /**
     * Get name space.
     *
     * @param string $dir
     *
     * @return string
     */
    protected function getNameSpace(string $dir): string
    {
        return module_namespace($this->moduleName, $dir);
    }

    /**
     * Get models name space.
     *
     * @return string
     */
    protected function getModelsNameSpace():string
    {
        return $this->getNameSpace('Models') . '\\' . $this->getModelName();
    }
}