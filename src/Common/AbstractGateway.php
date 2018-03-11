<?php

namespace Gregoriohc\Moneta\Common;

use ArrayAccess;
use Gregoriohc\Moneta\Common\Concerns\Parametrizable;
use IteratorAggregate;
use JsonSerializable;

/**
 * @method bool supportsAuthorize()
 * @method bool supportsCompleteAuthorize()
 * @method bool supportsCapture()
 * @method bool supportsPurchase()
 * @method bool supportsCompletePurchase()
 * @method bool supportsRefund()
 * @method bool supportsVoid()
 * @method bool supportsAcceptNotification()
 * @method bool supportsCreatePaymentMethod()
 * @method bool supportsDeletePaymentMethod()
 * @method bool supportsUpdatePaymentMethod()
 * @property bool test_mode
 */
abstract class AbstractGateway implements GatewayInterface, ArrayAccess, IteratorAggregate, JsonSerializable
{
    use Parametrizable;

    /**
     * @var mixed
     */
    protected $client;

    /**
     * Create a new gateway instance
     *
     * @param array $parameters
     */
    public function __construct($parameters = [])
    {
        $this->bootParameters($parameters);
        $this->bootClient();
    }

    /**
     * @return array
     */
    public function defaultParameters()
    {
        return [
            'test_mode' => false,
        ];
    }

    /**
     * @return array
     */
    public function parametersValidationRules()
    {
        return [
            'test_mode' => 'required',
        ];
    }

    /**
     * Get the short name of the Gateway
     *
     * @return string
     */
    public function shortName()
    {
        return class_basename($this);
    }

    /**
     * @return boolean
     */
    public function isInTestMode()
    {
        return $this->test_mode;
    }

    /**
     * @return mixed
     */
    public function client()
    {
        return $this->client;
    }

    /**
     * Create and initialize a request object
     *
     * @param string $class The request class name
     * @param array $parameters
     * @return \Gregoriohc\Moneta\Common\Messages\AbstractRequest
     */
    protected function createRequest($class, $parameters = [])
    {
        $this->validateParameters();

        return new $class($this, $parameters);
    }

    /**
     * @param string $name
     * @param $arguments
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        if (strpos($name, 'supports') === 0) {
            $name = lcfirst(substr($name, 8));
            return method_exists($this, $name);
        }

        $class = self::class;
        throw new \BadMethodCallException("Method '$class::$name' does not exists");
    }
}