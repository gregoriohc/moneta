<?php

namespace Gregoriohc\Moneta\Common\Models;

class BankAccount extends PaymentMethod
{
    /**
     * @return array
     */
    public function parametersValidationRules()
    {
        return [
            'full_name' => 'required|string',
            'number' => 'required|string',
        ];
    }
}