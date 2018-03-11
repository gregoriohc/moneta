<?php

namespace Gregoriohc\Moneta\Tests;

use Gregoriohc\Moneta\Common\Messages\BasicResponse;
use Gregoriohc\Moneta\Common\Models\Token;
use Gregoriohc\Moneta\Moneta;
use Gregoriohc\Moneta\Tests\Mocking\CaptureRequest;
use Gregoriohc\Moneta\Tests\Mocking\FakeGateway;

class ResponseTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @test
     */
    public function can_check_response()
    {
        /** @var FakeGateway $gateway */
        $gateway = Moneta::create(FakeGateway::class, [
            'api_key' => 'qwerty12345',
        ]);

        /** @var CaptureRequest $request */
        $request = $gateway->capture([
            'token' => new Token([
                'code' => '4111111111111111',
            ]),
            'amount' => 100,
            'currency' => 'USD',
        ]);

        /** @var BasicResponse $response */
        $response = $request->send();
        $this->assertInstanceOf(BasicResponse::class, $response);

        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isCancelled());
        $this->assertFalse($response->isRedirect());
        $this->assertFalse($response->isTransparentRedirect());

        $responseData = $response->data();
        $this->assertEquals([
            'token' => ['code' => '4111111111111111'],
            'amount' => 100,
            'currency' => 'USD',
        ], $responseData);

        $this->assertInstanceOf(CaptureRequest::class, $response->request());
    }
}
