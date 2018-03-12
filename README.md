# Moneta

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

A framework agnostic, multi-gateway payment processing library for PHP 7.0+

## Install

Via Composer

``` bash
$ composer require gregoriohc/moneta
```

Install required gateways, for example:

``` bash
$ composer require gregoriohc/moneta-stripe
```

## Usage

``` php
$gateway = Moneta::create('Stripe', [
    'test_mode' => true',
    'api_key' => 'API_KEY',
]);

$response = $request = $gateway->capture([
    'card' => new Card([
        'full_name' => 'John Doe',
        'number' => '4111111111111111',
        'expiration_month' => '06',
        'expiration_year' => '2024',
        'verification_value' => '123',
    ]),
    'amount' => 100,
    'currency' => 'USD',
])->send();

if ($response->isSuccessful()) {
    // Do something with the $response->data()
}
```

## Testing

``` bash
$ composer test
```

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email gregoriohc@gmail.com instead of using the issue tracker.

## Socialware

You're free to use this package, but if it makes it to your production environment I highly appreciate you sharing it on any social network.

## Credits

- [Gregorio Hernández Caso][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/gregoriohc/moneta.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/gregoriohc/moneta/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/gregoriohc/moneta.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/gregoriohc/moneta.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/gregoriohc/moneta.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/gregoriohc/moneta
[link-travis]: https://travis-ci.org/gregoriohc/moneta
[link-scrutinizer]: https://scrutinizer-ci.com/g/gregoriohc/moneta/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/gregoriohc/moneta
[link-downloads]: https://packagist.org/packages/gregoriohc/moneta
[link-author]: https://github.com/gregoriohc
[link-contributors]: ../../contributors
