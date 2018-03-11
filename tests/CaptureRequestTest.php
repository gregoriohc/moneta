<?php

namespace Gregoriohc\Moneta\Tests;

use Gregoriohc\Moneta\Common\Exceptions\InvalidParametersException;
use Gregoriohc\Moneta\Common\Models\Card;
use Gregoriohc\Moneta\Common\Models\Token;
use Gregoriohc\Moneta\Moneta;
use Gregoriohc\Moneta\Tests\Mocking\CaptureRequest;
use Gregoriohc\Moneta\Tests\Mocking\FakeGateway;
use Gregoriohc\Moneta\Tests\Mocking\FakeResponse;
use RuntimeException;

class CaptureRequestTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @test
     */
    public function can_capture_amount_with_card()
    {
        /** @var FakeGateway $gateway */
        $gateway = Moneta::create(FakeGateway::class, [
            'api_key' => 'qwerty12345',
        ]);
        $this->assertInstanceOf(FakeGateway::class, $gateway);
        $this->assertTrue($gateway->supportsCapture());

        $card = new Card([
            'full_name' => 'John Doe',
            'number' => '4111111111111111',
            'expiration_month' => '06',
            'expiration_year' => '2024',
            'verification_value' => '123',
        ]);
        $this->assertEquals('Card', $card->paymentMethodType());

        /** @var CaptureRequest $request */
        $request = $gateway->capture([
            'card' => $card,
            'amount' => 100,
            'currency' => 'USD',
        ]);
        $this->assertInstanceOf(CaptureRequest::class, $request);

        /** @var FakeResponse $response */
        $response = $request->send();
        $this->assertInstanceOf(FakeResponse::class, $response);

        $this->assertTrue($response->isSuccessful());

        $responseData = $response->data();
        $this->assertEquals([
            'card' => $card->parametersToArray(),
            'amount' => 100,
            'currency' => 'USD',
        ], $responseData);
    }

    /**
     * @test
     */
    public function can_capture_amount_with_token()
    {
        /** @var FakeGateway $gateway */
        $gateway = Moneta::create(FakeGateway::class, [
            'api_key' => 'qwerty12345',
        ]);
        $this->assertInstanceOf(FakeGateway::class, $gateway);
        $this->assertTrue($gateway->supportsCapture());

        $token = new Token([
            'code' => 'abcd1234',
        ]);

        /** @var CaptureRequest $request */
        $request = $gateway->capture([
            'token' => $token,
            'amount' => 100,
            'currency' => 'USD',
        ]);
        $this->assertInstanceOf(CaptureRequest::class, $request);

        /** @var FakeResponse $response */
        $response = $request->send();
        $this->assertInstanceOf(FakeResponse::class, $response);

        $responseData = $response->data();
        $this->assertEquals([
            'token' => $token->parametersToArray(),
            'amount' => 100,
            'currency' => 'USD',
        ], $responseData);
    }

    /**
     * @test
     */
    public function fails_capturing_without_payment_method_model()
    {
        /** @var FakeGateway $gateway */
        $gateway = Moneta::create(FakeGateway::class, [
            'api_key' => 'qwerty12345',
        ]);

        $this->expectException(InvalidParametersException::class);
        $this->expectExceptionMessage("'CaptureRequest' validation failed: The card must be a model of type Card.");

        $gateway->capture([
            'card' => '1234',
            'amount' => 100,
            'currency' => 'USD',
        ])->send();
    }

    /**
     * @test
     */
    public function fails_capturing_with_no_valid_card()
    {
        /** @var FakeGateway $gateway */
        $gateway = Moneta::create(FakeGateway::class, [
            'api_key' => 'qwerty12345',
        ]);

        $card = new Card([
            'number' => '4111111111111111',
            'expiration_month' => '06',
            'expiration_year' => '2024',
            'verification_value' => '123',
        ]);

        $this->expectException(InvalidParametersException::class);
        $this->expectExceptionMessage("'Card' validation failed: The full name field is required.");

        $gateway->capture([
            'card' => $card,
            'amount' => 100,
            'currency' => 'USD',
        ])->send();
    }

    /**
     * @test
     */
    public function fails_getting_response_before_send()
    {
        /** @var FakeGateway $gateway */
        $gateway = Moneta::create(FakeGateway::class, [
            'api_key' => 'qwerty12345',
        ]);

        $request = $gateway->capture([
            'card' => new Card([
                'number' => '4111111111111111',
                'expiration_month' => '06',
                'expiration_year' => '2024',
                'verification_value' => '123',
            ]),
            'amount' => 100,
            'currency' => 'USD',
        ]);

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage("You must call send() before accessing the Response.");

        $request->response();
    }

    /**
     * @test
     */
    public function can_get_response_gateway_and_client()
    {
        /** @var FakeGateway $gateway */
        $gateway = Moneta::create(FakeGateway::class, [
            'api_key' => 'qwerty12345',
        ]);

        $request = $gateway->capture([
            'token' => new Token([
                'code' => '4111111111111111',
            ]),
            'amount' => 100,
            'currency' => 'USD',
        ]);

        $request->send();

        $response = $request->response();
        $this->assertInstanceOf(FakeResponse::class, $response);

        $gateway = $request->gateway();
        $this->assertInstanceOf(FakeGateway::class, $gateway);

        $client = $request->gateway()->client();
        $this->assertInstanceOf('stdClass', $client);
    }
}
