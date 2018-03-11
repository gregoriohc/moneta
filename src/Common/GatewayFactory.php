<?php

namespace Gregoriohc\Moneta\Common;

use RuntimeException;

class GatewayFactory
{
    /**
     * Create a new gateway instance
     *
     * @param string $name
     * @param array $parameters
     * @return GatewayInterface
     */
    public function create($name, $parameters = [])
    {
        $class = $this->gatewayClass($name);

        if (!class_exists($class)) {
            throw new RuntimeException("Gateway class '$class' does not exists");
        }

        return new $class($parameters);
    }

    /**
     * @param string $name
     * @return string
     */
    private function gatewayClass($name)
    {
        if (strstr($name, '\\')) {
            return $name;
        }

        return 'Gregoriohc\\Moneta\\' . ucfirst($name) . '\\Gateway';
    }
}