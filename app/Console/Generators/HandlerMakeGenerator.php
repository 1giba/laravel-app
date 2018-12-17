<?php

namespace App\Console\Generators;

use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputOption;
use Config;

class HandlerMakeGenerator extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'make:handler';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new handler class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Service Handler';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        if ($this->option('model') && in_array($this->option('action'), [
            'create',
            'update',
            'delete',
        ])) {
            return storage_path('scaffold') . '/' . $this->option('action') . '.handler.stub';
        }

        return storage_path('scaffold') . '/handler.stub';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace .'\\' . Config::get('generators.namespaces.handlers');
    }

    /**
     * { @inheritdoc }
     */
    protected function getOptions()
    {
        return array_merge(parent::getOptions(), [
            [
                'model', null, InputOption::VALUE_OPTIONAL, 'Generate a resource handler for the given model',
            ],
            [
                'action', null, InputOption::VALUE_OPTIONAL, 'Create a new handler to resource',
            ],
        ]);
    }

    /**
     * Build the class with the given name.
     *
     * @param  string  $name
     * @return string
     */
    protected function buildClass($name)
    {
        $stub = parent::buildClass($name);

        $model = $this->option('model');

        if (! $model) {
            return str_replace(
                'DummyContractsNamespace',
                $this->rootNamespace() . Config::get('generators.namespaces.contracts'),
                $stub
            );
        }

        return str_replace([
            'DummyContractsNamespace',
            'DummyRepositoryFullClass',
            'DummyRepositoryClass',
            'DummyRepositoryVariable',
        ], [
            $this->rootNamespace() . Config::get('generators.namespaces.contracts'),
            $this->rootNamespace() . Config::get('generators.namespaces.repositories') . '\\' . $model . 'Repository',
            $model . 'Repository',
            lcfirst($model) . 'Repository',
        ], $stub);
    }
}
