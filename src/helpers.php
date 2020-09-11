<?php

/*
 * This file is part of the an5dy/laravel-admin-menus.
 *
 * (c) an5dy <846562014@qq.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

if (!function_exists('module_namespace')) {
    /**
     *  Get module namespace.
     *
     * @param string ...$namespace
     */
    function module_namespace(string ...$namespace): string
    {
        $namespace = rtrim('App\\'.implode('\\', $namespace), '\\');

        return $namespace;
    }
}
