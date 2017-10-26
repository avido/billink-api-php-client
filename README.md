# Billink API Client for PHP

This is an open source PHP client for the [Billink API] (https://test.billink.nl/api/docs | https://www.billink.nl/).

## Not on composer yet

## Installation
Get it with [composer](https://getcomposer.org)

Run the command:
```
composer require avido/billink-api-php-client
```
## client initialization: 

```php
require __DIR__ . '/vendor/autoload.php';
use Avido\BillinkApiClient\BillinkClient;
$username = '--YOUR USERNAME--';
$client_id = '--YOUR CLIENT ID--';
$client = new BillinkClient($username, $client_id);
// test mode true|false
$client->setTestMode(true);
```

## Unit tests
```xml
<phpunit>
  ...
    <php>
        <env name="PHP_USERNAME" value="--YOUR USERNAME--"/>
        <env name="PHP_CLIENTID" value="--YOUR CLIENT ID--"/>
    </php>
</phpunit>
```

See the tests folder for more information and examples
