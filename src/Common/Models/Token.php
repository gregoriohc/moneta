<?php

namespace Gregoriohc\Moneta\Common\Models;

class Token extends PaymentMethod
{
    /**
     * @return array
     */
    public function parametersValidationRules()
    {
        return [
            'code' => 'required|string',
        ];
    }
}