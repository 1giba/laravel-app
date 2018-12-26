<?php

namespace App\Models;

use Spatie\Permission\Models\Role as Model;
use Laracasts\Presenter\PresentableTrait;
use App\Models\Presenters\RolePresenter;

class Role extends Model
{
    use PresentableTrait;

    /**
     * @var string
     */
    protected $presenter = RolePresenter::class;
}
