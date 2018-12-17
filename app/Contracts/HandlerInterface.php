<?php

namespace App\Contracts;

interface HandlerInterface
{
    /**
     * Main method
     *
     * @param \App\Contracts\CommandInterface $command
     * @return mixed
     */
    public function handle(CommandInterface $command);
}
