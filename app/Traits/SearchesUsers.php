<?php

namespace App\Traits;

use Illuminate\Pagination\LengthAwarePaginator;
use App\Repositories\UserRepository;

trait SearchesUsers
{
    /**
     * @var \App\Repositories\UserRepository
     */
    protected $userRepository;

    /**
     * Get UserRepository instance
     *
     * @return UserRepository
     */
    public function getUserRepository(): UserRepository
    {
        if ($this->userRepository === null) {
            $this->userRepository = app(UserRepository::class);
        }

        return $this->userRepository;
    }

    /**
     * Paginate Users
     *
     * @param array $query
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function paginateUsers(array $query): LengthAwarePaginator
    {
        return $this->getUserRepository()
            ->queryString($query)
            ->paginate(25);
    }
}
