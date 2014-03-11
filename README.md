BIG Register SoapClient
=======================
[![Build Status](https://travis-ci.org/waarneembemiddeling/bigregister-soap.png?branch=master)](https://travis-ci.org/waarneembemiddeling/bigregister-soap)

This is a lightweight implementation of the [BIG register Soap interface.](https://www.bigregister.nl/zoeken/zoeken_eigen_systeem/).
A mapping of all the Soap types is provided.

## Installation
Start by [installing composer](http://getcomposer.org/doc/01-basic-usage.md#installation) and finally
[install the dependencies](http://getcomposer.org/doc/01-basic-usage.md#installing-dependencies).

## Requirements
PHP >=5.3.0 and ext-soap

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

## Overriding the constructor of the native SoapClient
We're using the native php SoapClient. If you want to change the WSDL (f.e. if you want to use the demo environment)
or want to override the options in order to debug the client you can do so:

```php
<?php

$wsdl = 'http://host.tld/myWsdl';
$options = array(
    'trace' => true
);
$client = new \Wb\BigRegister\SoapClient\Client($wsdl, $options);

```

For more information about the native client check [php.net](http://nl3.php.net/manual/en/soapclient.soapclient.php).
