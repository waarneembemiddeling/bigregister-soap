<?php

namespace Wb\BigRegister\SoapClient;

use Wb\BigRegister\SoapClient\Model\ListHcpApproxRequest;
use Wb\BigRegister\SoapClient\Model\ListHcpApproxResponse3;

class Service
{
    protected $client;

    public function __construct(Client $client = null)
    {
        $this->client = $client ? $client : new Client();
    }

    public function findByRegistrationNumber($number)
    {
        $request = new ListHcpApproxRequest();
        $request->RegistrationNumber = $number;
        $response = $this->doRequest($request);

        return current($response);
    }

    public function findByLastnameAndCity($lastname, $city)
    {
        $request = new ListHcpApproxRequest();
        $request->Name = $lastname;
        $request->City = $city;

        return $this->doRequest($request);
    }

    public function findAll(ListHcpApproxRequest $request)
    {
        return $this->doRequest($request);
    }

    protected function doRequest(ListHcpApproxRequest $request)
    {
        $response = $this->client->ListHcpApprox3($request);

        return $this->parseResponse($response);
    }

    protected function parseResponse(ListHcpApproxResponse3 $response)
    {
        $parser = new ResponseParser();

        return $parser->parse($response);
    }
}
