<?php

namespace App\Traits;

use Illuminate\Pagination\LengthAwarePaginator;
use App\Repositories\RoleRepository;

trait SearchesRoles
{
    /**
     * @var \App\Repositories\RoleRepository
     */
    protected $roleRepository;

    /**
     * Get RoleRepository instance
     *
     * @return RoleRepository
     */
    public function getRoleRepository(): RoleRepository
    {
        if ($this->roleRepository === null) {
            $this->roleRepository = app(RoleRepository::class);
        }

        return $this->roleRepository;
    }

    /**
     * Paginate Roles
     *
     * @param array $query
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function paginateRoles(array $query): LengthAwarePaginator
    {
        return $this->getRoleRepository()
            ->queryString($query)
            ->paginate(25);
    }
}
