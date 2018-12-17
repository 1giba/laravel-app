<?php

namespace App\Services\Commands\Common;

use App\Contracts\CommandInterface;

class BaseCreate implements CommandInterface
{
    /**
     * @var array
     */
    protected $data;

    /**
     * @param array $data
     * @return void
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }
}
