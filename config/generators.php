<?php

/*
 |
 | Using in artisan commands make:*
 |
 */

return [
    'namespaces' => [
        'contracts'     => 'Contracts',
        'models'        => 'Models',
        'presenters'    => 'Models\\Presenters',
        'repositories'  => 'Repositories',
        'controllers'   => 'Http\\Controllers\\Web',
        'api'           => 'Http\\Controllers\\Api',
        'commands'      => 'Services\\Commands',
        'handlers'      => 'Services\\Handlers',
        'traits'        => 'Traits',
    ],
    'paths' => [
        'artisan' => 'app/Console/Commands',
        'contracts' => 'app/Contracts',
        'exceptions' => 'app/Exceptions',
        'web' => 'app/Http/Controllers/Web',
        'api' => 'app/Http/Controllers/Api',
        'models' => 'app/Models',
        'presenters' => 'app/Models/Presenters',
        'repositories' => 'app/Repositories',
        'commands' => 'app/Services/Commands',
        'handlers' => 'app/Services/Handlers',
        'traits' => 'app/Traits',
    ],
    'files' => [
        'config/auth.php',
        'config/service.php',
        'database/factories/UserFactory.php',
    ],
];