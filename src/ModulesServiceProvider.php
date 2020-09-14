<?php

/*
 * This file is part of the an5dy/laravel-admin-menus.
 *
 * (c) an5dy <846562014@qq.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

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
