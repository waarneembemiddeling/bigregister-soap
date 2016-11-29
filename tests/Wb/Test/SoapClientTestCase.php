<?php
/*
* (c) Waarneembemiddeling.nl
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Wb\Test;

use PHPUnit\Framework\TestCase;
use Wb\BigRegister\SoapClient\Client;

class SoapClientTestCase extends TestCase
{
    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|Client
     */
    public function getSoapClient()
    {
        $client = $this->getMockBuilder(Client::class)
            ->setMethods(['__doRequest'])
            ->setConstructorArgs([__DIR__.'/../../../resources/bigregister.wsdl'])
            ->getMock();

        $client->expects($this->any())
            ->method('__doRequest')
            ->will($this->returnValue(file_get_contents(__DIR__.'/../../../resources/response.xml')));

        return $client;
    }
}
