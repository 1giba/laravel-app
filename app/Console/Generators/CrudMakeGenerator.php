<?php

namespace App\Console\Generators;

use Illuminate\Console\Command;
use Illuminate\Console\DetectsApplicationNamespace;
use Config;

class CrudMakeGenerator extends Command
{
    use DetectsApplicationNamespace;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:crud
        { resources : Resource name in plural }
        { --force : Overwrite existing files by default }';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a complete CRUD';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Crud';

    /**
     * The views that need to be exported.
     *
     * @var array
     */
    protected $views = [
        'index.stub'    => 'index.blade.php',
        'create.stub'   => 'create.blade.php',
        'edit.stub'     => 'edit.blade.php',
    ];

    /**
     * @var array
     */
    protected $dummies = [];

    /**
     * Set Dummies
     *
     * @param string $resources
     * @return $this
     */
    public function dummies(string $resources): self
    {
        $resClass       = ucfirst(str_singular($resources));
        $resVar         = lcfirst(str_singular($resources));
        $resClasses     = ucfirst(str_plural($resources));
        $resVariables   = lcfirst(str_plural($resources));

        $create = 'Create' . $resClass;
        $update = 'Update' . $resClass;
        $delete = 'Delete' . $resClass;

        $appNs      = $this->getAppNamespace();
        $cmdNs      = $appNs . Config::get('generators.namespaces.commands');
        $ctlNs      = $appNs . Config::get('generators.namespaces.controllers');
        $traitNs    = $appNs . Config::get('generators.namespaces.traits');

        $this->dummies = [
            'DummyResourceClass'            => $resClass,
            'DummyResourceVariable'         => $resVar,
            'DummyResourcesClass'           => $resClasses,
            'DummyResourcesVariable'        => $resVariables,
            'DummyControllerNamespace'      => $ctlNs,
            'DummyControllerClass'          => $resClass . 'Controller',
            'DummyModelClass'               => $resClass,
            'DummyFullModelClass'           => $appNs . $resClass,
            'DummyFullCreateCommandClass'   => $cmdNs . '\\' . $create,
            'DummyFullUpdateCommandClass'   => $cmdNs . '\\' . $update,
            'DummyFullDeleteCommandClass'   => $cmdNs . '\\' . $delete,
            'DummyCreateCommandClass'       => $create,
            'DummyUpdateCommandClass'       => $update,
            'DummyDeleteCommandClass'       => $delete,
            'DummyTraitsNamespace'          => $traitNs,
            'DummySearchClass'              => 'Searches' . $resClasses,
        ];

        return $this;
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->dummies($this->argument('resources'));

        $this->createMigrations();
        $this->createDatabaseLayer();
        $this->createServiceLayer();
        $this->createSearchTrait();

        $this->createDirectory();
        $this->exportViews();

        $this->createMenu();

        $this->createLang('en');
        $this->createLang('pt-BR');

        $this->createWebController();
        $this->createRoutes();

        $this->info('CRUD scaffolding generated successfully.');
        $this->comment('Edit the migration file and run.');
    }

    /**
     * Create the migration
     *
     * @return void
     */
    protected function createMigrations()
    {
        $this->call('make:migration', [
            'name' => 'create_' . $this->dummies['DummyResourcesVariable'] . '_table',
        ]);
    }

    /**
     * Create the directories for the files.
     *
     * @return void
     */
    protected function createDirectory()
    {
        if (! is_dir($directory = resource_path('views/' . $this->dummies['DummyResourcesVariable']))) {
            mkdir($directory, 0755, true);
        }
    }

    /**
     * Export the crud views.
     *
     * @return void
     */
    protected function exportViews()
    {
        foreach ($this->views as $key => $value) {
            if (file_exists($view = resource_path('views/' .
                $this->dummies['DummyResourcesVariable'] . '/' . $value)) &&
                ! $this->option('force')) {
                if (! $this->confirm("The [{$value}] view already exists. Do you want to replace it?")) {
                    continue;
                }
            }

            file_put_contents($view, $this->replace(
                file_get_contents(storage_path('scaffold') . '/' . $key)
            ));
        }
    }

    /**
     * Create database layer
     *
     * @return void
     */
    public function createDatabaseLayer()
    {
        $this->call('make:model', [
            'name' => $this->dummies['DummyModelClass'],
            '--presenter' => true,
            '--repository' => true,
            '--factory' => true,
        ]);
    }

    /**
     * Create service layer
     *
     * @return void
     */
    public function createServiceLayer()
    {
        $actions = [
            'create' => $this->dummies['DummyCreateCommandClass'],
            'update' => $this->dummies['DummyUpdateCommandClass'],
            'delete' => $this->dummies['DummyDeleteCommandClass'],
        ];

        foreach ($actions as $action => $class) {
            $service = $this->dummies['DummyResourcesClass'] . '\\' . $class;

            $this->call('make:command', [
                'name'      => $service,
                '--action'  => $action,
            ]);

            $this->call('make:handler', [
                'name'      => $service,
                '--action'  => $action,
                '--model'   => $this->dummies['DummyModelClass'],
            ]);
        }
    }

    /**
     * Create search Trait
     *
     * @return void
     */
    public function createSearchTrait()
    {
        $this->call('make:trait', [
            'name'      => $this->dummies['DummySearchClass'],
            '--search'  => $this->dummies['DummyModelClass'],
        ]);
    }

    /**
     * Create lang
     *
     * @param string $dir
     * @return void
     */
    public function createLang(string $dir = 'en')
    {
        if (! is_dir($directory = resource_path('lang/' . $dir))) {
            mkdir($directory, 0755, true);
        }

        file_put_contents(
            $directory . '/' . $this->dummies['DummyResourcesVariable'] . '.php',
            $this->replace(
                file_get_contents(storage_path('scaffold') . '/lang.stub')
            )
        );

        $this->info('Lang created successfully.');
    }

    /**
     * Compila o arquivo stub
     *
     * @param string $template
     * @return string
     */
    public function replace(string $template): string
    {
        return str_replace(
            array_keys($this->dummies),
            array_values($this->dummies),
            $template
        );
    }

    /**
     * Create a controller
     *
     * @return void
     */
    public function createWebController()
    {
        $path = str_replace('\\', '/', Config::get('generators.namespaces.controllers'));
        file_put_contents(
            app_path($path . '/' . $this->dummies['DummyControllerClass'] . '.php'),
            $this->replace(file_get_contents(storage_path('scaffold') . '/web.controller.stub'))
        );

        $this->info('Controller created successfully.');
    }

    /**
     * Create a controller
     *
     * @return void
     */
    public function createMenu()
    {
        file_put_contents(
            resource_path('views/partials/menu.blade.php'),
            $this->replace(file_get_contents(storage_path('scaffold') .'/menu.stub')),
            FILE_APPEND
        );

        $this->info('Menu created successfully.');
    }

    /**
     * Create crud routes
     *
     * @return void
     */
    public function createRoutes()
    {
        file_put_contents(
            base_path('routes/web.php'),
            $this->replace(file_get_contents(storage_path('scaffold') .'/routes.stub')),
            FILE_APPEND
        );

        $this->info('Routes created successfully.');
    }
}
