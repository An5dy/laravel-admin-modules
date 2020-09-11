<?php

if (!function_exists('module_namespace')) {
    /**
     *  Get module namespace.
     *
     * @param string ...$namespace
     *
     * @return string
     */
    function module_namespace(string ...$namespace): string
    {
        $namespace = rtrim('App\\' . implode("\\", $namespace), '\\');

        return $namespace;
    }
}