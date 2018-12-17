<?php

namespace App\Repositories;

use OneGiba\DataLayer\Repository;
use OneGiba\DataLayer\Traits\Debuggable;
use OneGiba\DataLayer\Traits\Requestable;

abstract class AbstractRepository extends Repository
{
    use Debuggable, Requestable;
}
