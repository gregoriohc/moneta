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
    public function create($name, $parameters = null)
    {
        $class = $this->gatewayClass($name);

        if (!class_exists($class)) {
            throw new RuntimeException("Gateway class '$class' does not exists");
        }

        $parameters = $this->resolveParameters($name, $parameters);

        return new $class($parameters);
    }

    private function resolveParameters($name, $parameters)
    {
        if (!is_array($parameters)) {
            $parameters = [];
        }

        if (function_exists('config')) {
            $parameters = config('moneta.gateways.' . $name, []);

            if (!array_key_exists('test_mode', $parameters)) {
                $parameters = config('moneta.test_mode', true);
            }
        }

        return $parameters;
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