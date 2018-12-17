<?php

namespace App\Services\Commands\Common;

use App\Contracts\CommandInterface;

class BaseDelete implements CommandInterface
{
    /**
     * @var int
     */
    protected $resourceId;

    /**
     * @param int $resourceId
     * @return void
     */
    public function __construct(int $resourceId)
    {
        $this->resourceId = $resourceId;
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
