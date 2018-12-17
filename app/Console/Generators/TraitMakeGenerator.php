<?php

namespace App\Console\Generators;

use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputOption;
use Config;

class TraitMakeGenerator extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'make:trait';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new trait';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Trait';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        if ($this->option('search')) {
            return storage_path('scaffold') . '/search.trait.stub';
        }

        return storage_path('scaffold') . '/trait.stub';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\\' . Config::get('generators.namespaces.traits');
    }

    /**
     * Build the class with the given name.
     *
     * @param  string  $name
     * @return string
     */
    protected function buildClass($name)
    {
        if (! $model = $this->option('search')) {
            return parent::buildClass($name);
        }

        return str_replace([
            'DummyFullRepositoryClass',
            'DummyRepositoryClass',
            'DummyRepositoryVariable',
            'DummyPluralClass',
            'DummyModelClass',
            'DummyModelVariable',
        ], [
            $this->rootNamespace() . Config::get('generators.namespaces.repositories') . '\\' . $model . 'Repository',
            $model . 'Repository',
            lcfirst($model) . 'Repository',
            str_plural($model),
            $model,
            lcfirst($model),
        ], parent::buildClass($name));
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['search', null, InputOption::VALUE_OPTIONAL, 'Generate a default search trait'],
        ];
    }
}
