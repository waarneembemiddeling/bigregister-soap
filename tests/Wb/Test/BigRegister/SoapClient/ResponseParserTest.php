<?php
/*
* (c) Waarneembemiddeling.nl
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Wb\Test\BigRegister\SoapClient;

use Wb\BigRegister\SoapClient\ResponseParser;
use Wb\Test\SoapClientTestCase;

class ResponseParserTest extends SoapClientTestCase
{
    public function testParse()
    {
        $client = $this->getMockSoapClient();
        $response = $client->ListHcpApprox3();

        $parser = new ResponseParser();
        $result = $parser->parse($response);
        $this->assertInternalType('array', $result);
        $this->assertCount(1, $result);
        $this->assertArrayHasKey(0, $result);
        $result = $result[0];
        $this->assertArrayHasKey('articles', $result);
        $this->assertArrayHasKey('specialisms', $result);
        $this->assertArrayHasKey('mentions', $result);
        $this->assertArrayHasKey('judgements', $result);
        $this->assertArrayHasKey('limitations', $result);

        $this->assertSame('J.J. van der Jansen', $result['name']);
        $this->assertSame('van der', $result['prefix']);
        $this->assertSame('Vrouw', $result['gender']);
        $this->assertSame('huisartsgeneeskunde', $result['specialisms'][0]['name']);
        $this->assertSame('medische zorg voor verstandelijke gehandicapten', $result['specialisms'][1]['name']);

    }
} 
