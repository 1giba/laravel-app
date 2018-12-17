<?php

namespace App\Console\Generators;

use Illuminate\Database\Console\Factories\FactoryMakeCommand;
use Config;

class FactoryMakeGenerator extends FactoryMakeCommand
{
    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\\' . Config::get('generators.namespaces.models');
    }
}
