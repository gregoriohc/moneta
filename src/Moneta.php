<?php

namespace Gregoriohc\Moneta;

use Gregoriohc\Moneta\Common\GatewayFactory;
use Gregoriohc\Moneta\Common\GatewayInterface;

/**
 * @method static GatewayInterface create($name, $parameters = [])
 * @mehtod
 *
 * @see GatewayFactory
 */
class Moneta
{
    /**
     * Internal factory storage
     *
     * @var GatewayFactory
     */
    private static $factory;

    /**
     * Get the gateway factory
     *
     * Creates a new empty GatewayFactory if none has been set previously.
     *
     * @return GatewayFactory A GatewayFactory instance
     */
    public static function factory()
    {
        if (is_null(self::$factory)) {
            self::$factory = new GatewayFactory;
        }

        return self::$factory;
    }

    /**
     * Static function call router.
     *
     * All other function calls to the Moneta class are routed to the factory.
     *
     * Example:
     *
     * <code>
     *   // Create a PayPal gateway
     *   $gateway = Moneta::create('ExpressGateway');
     * </code>
     *
     * @param string $method     The factory method to invoke.
     * @param array  $parameters Parameters passed to the factory method.
     *
     * @return mixed
     */
    public static function __callStatic($method, $parameters)
    {
        return call_user_func_array([self::factory(), $method], $parameters);
    }
}
