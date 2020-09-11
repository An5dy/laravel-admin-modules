<?php

namespace An5dy\LaravelAdminModules;

use Illuminate\Support\ServiceProvider;

class ModulesServiceProvider extends ServiceProvider
{
    /**
     * The commands.
     *
     * @var string[]
     */
    protected $commands = [
        Console\ControllerMakeCommand::class,
        Console\ModuleBootstrapMakeCommand::class,
        Console\ModuleMakeCommand::class,
        Console\ProviderMakeCommand::class,
        Console\RequestMakeCommand::class,
    ];

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->commands($this->commands);
    }
}