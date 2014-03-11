BIG Register SoapClient
=======================

This is a lightweight implementation of the [BIG register Soap interface.](https://www.bigregister.nl/zoeken/zoeken_eigen_systeem/).
A mapping of all the Soap types is provided.

## Installation
Start by [installing composer](http://getcomposer.org/doc/01-basic-usage.md#installation) and finally
[install the dependencies](http://getcomposer.org/doc/01-basic-usage.md#installing-dependencies).

## Requirements
PHP >=5.3.0

## Usage
Creating a new instance is as simple as:

```php
<?php

$client = new \Wb\BigRegister\SoapClient\Client();

```

### Perform a search
Search on a number:

```php
<?php

$client = new \Wb\BigRegister\SoapClient\Client();
$request = new \Wb\BigRegister\SoapClient\Model\ListHcpApproxRequest();
$request->RegistrationNumber = '123';
$response = $client->ListHcpApprox3($request);

// dump the response
print_r($response);

```

## Overriding constructor
If you want to override the WSDL of the options:

```php
<?php

$wsdl = 'http://host.tld/myWsdl';
$options = array(
    'trace' => true
);
$client = new \Wb\BigRegister\SoapClient\Client($wsdl, $options);

```
