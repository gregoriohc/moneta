<?php

namespace Gregoriohc\Moneta\Common\Models;

use ArrayAccess;
use Gregoriohc\Moneta\Common\Concerns\Parametrizable;
use IteratorAggregate;
use JsonSerializable;

abstract class AbstractModel implements ArrayAccess, IteratorAggregate, JsonSerializable
{
    use Parametrizable;

    /**
     * AbstractModel constructor.
     *
     * @param $parameters
     */
    public function __construct($parameters)
    {
        $this->bootParameters($parameters);
    }
}