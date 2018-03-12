<?php

namespace Gregoriohc\Moneta\Common\Models;

use Gregoriohc\Protean\Common\Models\AbstractModel;

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