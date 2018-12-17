<?php

namespace App\Console\Generators;

use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputOption;
use App\Traits\InjectsInGenerator;
use Config;

class PresenterMakeGenerator extends GeneratorCommand
{
    use InjectsInGenerator;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:presenter';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new presenter class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Presenter';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return storage_path('scaffold') . '/presenter.stub';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\\' . Config::get('generators.namespaces.presenters');
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['model', 'm', InputOption::VALUE_OPTIONAL, 'Generate a presenter for the given model.'],
        ];
    }
}
