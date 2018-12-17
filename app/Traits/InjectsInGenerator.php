<?php

namespace App\Traits;

use Illuminate\Support\Str;
use InvalidArgumentException;
use Config;

trait InjectsInGenerator
{
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
        $replace = $this->buildModelReplacements(
            $this->option('model')
            ?? str_replace($this->type, '', class_basename($name))
        );

        return str_replace(
            array_keys($replace),
            array_values($replace),
            parent::buildClass($name)
        );
    }

    /**
     * Build the model replacement values.
     *
     * @param string $model
     * @return array
     */
    protected function buildModelReplacements(string $model): array
    {
        $modelClass = $this->parseModel($model);

        if (! class_exists($modelClass)) {
            if ($this->confirm("A {$modelClass} model does not exist. Do you want to generate it?", true)) {
                $this->call('make:model', ['name' => $modelClass]);
            }
        }

        return [
            'DummyFullModelClass' => $modelClass,
            'DummyModelClass' => class_basename($modelClass),
            'DummyModelVariable' => lcfirst(class_basename($modelClass)),
            'DummyFullPresenterClass' => $modelClass . 'Presenter',
            'DummyPresenterClass' => class_basename($modelClass) . 'Presenter',
        ];
    }

    /**
     * Get the fully-qualified model class name.
     *
     * @param  string  $model
     * @return string
     *
     * @throws \InvalidArgumentException
     */
    protected function parseModel(string $model): string
    {
        if (preg_match('([^A-Za-z0-9_/\\\\])', $model)) {
            throw new InvalidArgumentException('Model name contains invalid characters.');
        }

        $model = trim(str_replace('/', '\\', $model), '\\');

        if (! Str::startsWith(
            $model,
            $rootNamespace = $this->laravel->getNamespace()
            . Config::get('generators.namespaces.models') . '\\'
        )) {
            $model = $rootNamespace . $model;
        }

        return $model;
    }
}
