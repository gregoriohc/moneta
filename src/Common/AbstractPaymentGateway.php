<?php

namespace Gregoriohc\Moneta\Common;

use Gregoriohc\Protean\Common\AbstractGateway;

/**
 * @method bool supportsAuthorize()
 * @method bool supportsCapture()
 * @method bool supportsPurchase()
 * @method bool supportsRefund()
 * @method bool supportsVoid()
 * @method bool supportsCreatePaymentMethod()
 * @method bool supportsDeletePaymentMethod()
 * @method bool supportsUpdatePaymentMethod()
 * @method bool supportsAcceptNotification()
 */
abstract class AbstractPaymentGateway extends AbstractGateway
{

    protected $requestMethods = [
        'authorize',
        'capture',
        'purchase',
        'refund',
        'void',
        'createPaymentMethod',
        'deletePaymentMethod',
        'updatePaymentMethod',
    ];

    protected $webhookMethods = [
        'acceptNotification',
    ];
}