<?php

namespace App\Services\Commands\Common;

use App\Contracts\CommandInterface;

class BaseUpdate implements CommandInterface
{
    /**
     * @var array
     */
    protected $data;

    /**
     * @var int
     */
    protected $resourceId;

    /**
     * @param array $data
     * @param int $resourceId
     * @return void
     */
    public function __construct(array $data, int $resourceId)
    {
        $this->data = $data;
        $this->resourceId = $resourceId;
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

    /**
     * Get resource id
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->resourceId;
    }
}
