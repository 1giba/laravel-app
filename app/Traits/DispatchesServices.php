<?php

namespace App\Traits;

use Joselfonseca\LaravelTactician\CommandBusInterface;

trait DispatchesServices
{
    /**
     * @var \Joselfonseca\LaravelTactician\CommandBusInterface
     */
    protected $bus;

    /**
     * @var array
     */
    protected $middlewares = [];

    /**
     * Dispara o serviço
     *
     * @param string $commandClass
     * @param array  $params
     * @return mixed
     */
    public function dispatchService(string $commandClass, array $params = [])
    {
        $this->getBus()->addHandler($commandClass, $this->getHandlerClass($commandClass));
        return $this->getBus()->dispatch($commandClass, $params, $this->middlewares);
    }

    /**
     * Captura o bus
     *
     * @return \Joselfonseca\LaravelTactician\CommandBusInterface
     */
    protected function getBus(): CommandBusInterface
    {
        if (empty($this->bus)) {
            $this->bus = app(CommandBusInterface::class);
        }
        return $this->bus;
    }

    /**
     * Resolve o nome do handler
     *
     * @param string $commandClass
     * @return string
     */
    protected function getHandlerClass(string $commandClass): string
    {
        return str_replace('Commands', 'Handlers', $commandClass);
    }
}
