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
            'full_name' => 'required|string',
            'number' => 'required|string',
            'expiration_month' => 'required|string|size:2',
            'expiration_year' => 'required|string|size:4',
            'verification_value' => 'required|string|min:3|max:4',
        ];
    }
}