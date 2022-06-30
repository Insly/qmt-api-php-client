# qmt-api-php-client
A PHP client library for interacting with QMT API services

## Installation

composer.json
```
"repositories": {
        ...
        "insly/qmt-api-php-client": {
            "type": "git",
            "url": "git@github.com:Insly/qmt-api-php-client.git"
        },
        ...
    }
```

`composer require insly/qmt-api-php-client`

## Running tests

#### Run unit tests

`vendor/bin/codecept run unit`
or
`composer test`


#### Run code style checks (Linux)

`./run_ecs_check.sh`


## Sample usage

```php
use \Insly\QmtApiClient\Config;
use \Insly\QmtApiClient\Api\Client;

...

$cfg = new Config([
    Config::PARAM_HOST => 'https://app.insly.com'
    Config::PARAM_AUTH_TOKEN => 'Bearer abcd...'
]);

$client = new Client($cfg)
$response = $client->master()->adminGetUsersList(['page_size' => 100]);

...
```
