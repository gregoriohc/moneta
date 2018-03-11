<?php

namespace Gregoriohc\Moneta\Tests\Mocking;

use Gregoriohc\Moneta\Common\AbstractGateway;

class FakeGateway extends AbstractGateway
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
     * @return \Gregoriohc\Moneta\Tests\Mocking\CaptureRequest
     */
    public function capture($parameters = [])
    {
        return $this->createRequest(CaptureRequest::class, $parameters);
    }

    /**
     * @param array $parameters
     * @return \Gregoriohc\Moneta\Tests\Mocking\FakeRequest
     */
    public function fake($parameters = [])
    {
        return $this->createRequest(FakeRequest::class, $parameters);
    }
}
