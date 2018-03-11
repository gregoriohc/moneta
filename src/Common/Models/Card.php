<?php

namespace Gregoriohc\Moneta\Common\Models;

class Card extends PaymentMethod
{
    /**
     * @return array
     */
    public function parametersValidationRules()
    {
        return [
            'full_name' => 'required',
            'number' => 'required',
            'expiration_month' => 'required',
            'expiration_year' => 'required',
            'verification_value' => 'required',
        ];
    }
}