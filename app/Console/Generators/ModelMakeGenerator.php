<?php

namespace App\Console\Generators;

use Illuminate\Support\Str;
use Illuminate\Foundation\Console\ModelMakeCommand;
use Symfony\Component\Console\Input\InputOption;
use Config;

class ModelMakeGenerator extends ModelMakeCommand
{
    /**
     * { @inheritdoc }
     */
    protected function getOptions()
    {
        return array_merge(parent::getOptions(), [
            [
                'presenter', null, InputOption::VALUE_NONE, 'Create a new presenter for the model',
            ],
            [
                'repository', null, InputOption::VALUE_NONE, 'Create a new repository for the model',
            ],
        ]);
    }

    /**
     * { @inheritdoc }
     */
    public function handle()
    {
        parent::handle();

        if ($this->option('all')) {
            $this->input->setOption('presenter', true);
            $this->input->setOption('repository', true);
        }

        if ($this->option('presenter')) {
            $this->createPresenter();
        }

        if ($this->option('repository')) {
            $this->createRepository();
        }
    }

    /**
     * Create a presenter for the model.
     *
     * @return void
     */
    protected function createPresenter()
    {
        $presenter = Str::studly(class_basename($this->argument('name')));

        $this->call('make:presenter', [
            'name' => "{$presenter}Presenter",
            '--model' => $this->argument('name'),
        ]);
    }

    /**
     * Create a repository for the model.
     *
     * @return void
     */
    protected function createRepository()
    {
        $repository = Str::studly(class_basename($this->argument('name')));

        $this->call('make:repository', [
            'name' => "{$repository}Repository",
            '--model' => $this->argument('name'),
        ]);
    }

    /**
     * { @inheritdoc }
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\\' . Config::get('generators.namespaces.models');
    }

    /**
     * { @inheritdoc }
     */
    protected function getStub()
    {
        if ($this->option('pivot') && $this->option('presenter')) {
            return storage_path('scaffold') . '/pivot.model.stub';
        }

        if ($this->option('presenter')) {
            return storage_path('scaffold') . '/presenter.model.stub';
        }

        return parent::getStub();
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

        return str_replace([
            'DummyFullPresenterClass',
            'DummyPresenterClass',
        ], [
            $this->rootNamespace() .
                Config::get('generators.namespaces.presenters') . '\\' .
                class_basename($name) . 'Presenter',
            class_basename($name) . 'Presenter',
        ], $stub);
    }
}
