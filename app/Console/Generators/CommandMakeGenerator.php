<?php

namespace App\Console\Generators;

use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputOption;
use Config;

class CommandMakeGenerator extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'make:command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new command class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Service Command';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        if (in_array($this->option('action'), [
            'create',
            'update',
            'delete',
        ])) {
            return storage_path('scaffold') . '/' . $this->option('action') . '.command.stub';
        }

        return storage_path('scaffold') . '/command.stub';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\\' . Config::get('generators.namespaces.commands');
    }

    /**
     * { @inheritdoc }
     */
    protected function getOptions()
    {
        return array_merge(parent::getOptions(), [
            [
                'action', null, InputOption::VALUE_OPTIONAL, 'Create a new command to resource',
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
        return str_replace([
            'DummyContractsNamespace',
            'DummyCommandsNamespace',
        ], [
            $this->rootNamespace() . Config::get('generators.namespaces.contracts'),
            $this->rootNamespace() . Config::get('generators.namespaces.commands'),
        ], parent::buildClass($name));
    }
}
