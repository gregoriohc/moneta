<?php

namespace Gregoriohc\Moneta\Common\Models;

use Gregoriohc\Moneta\Support\Helper;

abstract class PaymentMethod extends AbstractModel
{
    /**
     * @return string
     */
    public function paymentMethodType()
    {
        return class_basename($this);
    }
}