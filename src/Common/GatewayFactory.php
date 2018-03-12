<?php

namespace Gregoriohc\Moneta\Common;

use RuntimeException;

class GatewayFactory
{
    protected $contextNamespace;

    /**
     * GatewayFactory constructor.
     * @param string|null $contextNamespace
     */
    public function __construct($contextNamespace = null)
    {
        $this->contextNamespace = $contextNamespace ?: substr(get_class($this), 0, -strlen('\\Common\\GatewayFactory'));
    }


    /**
     * Create a new gateway instance
     *
     * @param string $name
     * @param array $parameters
     * @param mixed $context
     * @return GatewayInterface
     */
    public function create($name, $parameters = null, $context = null)
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

        return $this->contextNamespace . '\\' . ucfirst($name) . '\\Gateway';
    }
}