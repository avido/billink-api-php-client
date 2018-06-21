# Billink API Client for PHP

Open source PHP client for the [Billink API] (https://test.billink.nl/api/docs | https://www.billink.nl/).

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
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

$username = '--YOUR USERNAME--';
$client_id = '--YOUR CLIENT ID--';
$log = new StreamHandler('billink.log', LOGGER::DEBUG);
$client = new BillinkClient($username, $client_id, [$log=null]);
// test mode true|false
$client->setTestMode(true);
```

## Unit tests
```xml
<phpunit>
  ...
    <php>
        <env name="PHP_USERNAME" value="apitest"/>
        <env name="PHP_CLIENTID" value="d108a0f1bc5bc4618f150fa95cd6dc537bd774f0"/>
        <env name="API_WORKFLOW" value="1" />
        <env name="API_BACKDOOR" value="1" />
    </php>
</phpunit>
```
## Examples
Go to examples folder and run php build in server
```php
php -S 127.0.0.1:8081
```

