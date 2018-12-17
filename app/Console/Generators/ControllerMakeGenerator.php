<?php

namespace App\Console\Generators;

use Illuminate\Routing\Console\ControllerMakeCommand;
use Symfony\Component\Console\Input\InputOption;
use Config;

class ControllerMakeGenerator extends ControllerMakeCommand
{
    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . (
            $this->option('api')
            ? Config::get('generators.namespaces.api')
            : Config::get('generators.namespaces.controllers')
        );
    }

    /**
     * Build the class with the given name.
     *
     * Remove the base controller import if we are already in base namespace.
     *
     * @param  string  $name
     * @return string
     */
    protected function buildClass($name)
    {
        $class = parent::buildClass($name);

        return str_replace([
            'DummyTraitsNamespace',
            'DummySearchClass',
        ], [
            $this->laravel->getNamespace() . Config::get('generators.namespaces.trait'),
            'Searches' . $name,
        ], $class);
    }
}
