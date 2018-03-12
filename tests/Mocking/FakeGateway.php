<?php

namespace Gregoriohc\Moneta\Tests\Mocking;

use Gregoriohc\Moneta\Common\AbstractPaymentGateway;
use Gregoriohc\Protean\Common\Messages\RequestInterface;
use Gregoriohc\Moneta\Tests\Mocking\Messages\FakeRequest;

/**
 * @method RequestInterface capture($parameters = [])
 * @method bool supportsCapture()
 */
class FakeGateway extends AbstractPaymentGateway
{
    /**
     * @return array
     */
    public function parametersValidationRules()
    {
        return array_merge(parent::parametersValidationRules(), [
            'api_key' => 'required',
        ]);
    }

    /**
     * Get gateway display name
     *
     * This can be used by carts to get the display name for each gateway.
     *
     * @return string
     */
    public function name()
    {
        return 'Fake';
    }

    /**
     * Boot the gateway client
     */
    public function bootClient()
    {
        $this->client = new \stdClass();
    }

    /**
     * @param array $parameters
     * @return \Gregoriohc\Protean\Common\Messages\AbstractRequest
     */
    public function fake($parameters = [])
    {
        return $this->createRequest(FakeRequest::class, $parameters);
    }
}
