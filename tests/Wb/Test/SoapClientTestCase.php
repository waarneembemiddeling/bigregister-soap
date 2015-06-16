<?php
/*
* (c) Waarneembemiddeling.nl
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Wb\Test;

class SoapClientTestCase extends \PHPUnit_Framework_TestCase
{
    public function getSoapClient()
    {
        $client = $this->getMock(
            'Wb\BigRegister\SoapClient\Client',
            array('__doRequest'),
            array(__DIR__.'/../../../resources/bigregister.wsdl')
        );

        $client->expects($this->any())
            ->method('__doRequest')
            ->will($this->returnValue(file_get_contents(__DIR__.'/../../../resources/response.xml')));

        return $client;
    }
}
