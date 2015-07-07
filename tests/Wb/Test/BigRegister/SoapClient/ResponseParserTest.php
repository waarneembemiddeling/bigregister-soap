<?php
/*
* (c) Waarneembemiddeling.nl
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Wb\Test\BigRegister\SoapClient;

use Wb\BigRegister\SoapClient\Model\ListHcpApproxRequest;
use Wb\BigRegister\SoapClient\ResponseParser;
use Wb\Test\SoapClientTestCase;

class ResponseParserTest extends SoapClientTestCase
{
    public function testParse()
    {
        $client = $this->getSoapClient();
        $request = new ListHcpApproxRequest();
        $request->RegistrationNumber = '123456789';
        $response = $client->ListHcpApprox4($request);

        $parser = new ResponseParser();
        $result = $parser->parse($response);

        $this->assertInternalType('array', $result);
        $this->assertCount(1, $result);
        $this->assertArrayHasKey(0, $result);
        $result = $result[0];

        // Personal data
        $this->assertSame('Foo van Bar', $result['name']);
        $this->assertSame('van', $result['prefix']);
        $this->assertSame('Foo', $result['initial']);
        $this->assertSame('Bar', $result['birthSurname']);
        $this->assertSame('Man', $result['gender']);

        // Articles
        $this->assertArrayHasKey('articles', $result);
        $this->assertCount(1, $result['articles']);
        $this->assertSame('12345678910', $result['articles'][0]['bigNumber']);
        $this->assertInstanceOf('DateTime', $result['articles'][0]['start']);
        $this->assertSame('1998-02-06', $result['articles'][0]['start']->format('Y-m-d'));
        $this->assertNull($result['articles'][0]['end']);
        $this->assertSame('Artsen', $result['articles'][0]['profession']);

        // Specialisms
        $this->assertArrayHasKey('specialisms', $result);
        $this->assertCount(1, $result['specialisms']);
        $this->assertSame('huisartsgeneeskunde', $result['specialisms'][0]['name']);
        $this->assertSame('12345678910', $result['specialisms'][0]['bigNumber']);
        $this->assertNull($result['specialisms'][0]['start']);
        $this->assertNull($result['specialisms'][0]['end']);

        // Mentions
        $this->assertArrayHasKey('mentions', $result);
        $this->assertCount(0, $result['mentions']);

        // Judgements
        $this->assertArrayHasKey('judgements', $result);
        $this->assertCount(1, $result['judgements']);
        $this->assertSame('12345678910', $result['judgements'][0]['bigNumber']);
        $this->assertInstanceOf('DateTime', $result['judgements'][0]['start']);
        $this->assertSame('2015-03-31', $result['judgements'][0]['start']->format('Y-m-d'));
        $this->assertInstanceOf('DateTime', $result['judgements'][0]['end']);
        $this->assertSame('2020-03-30', $result['judgements'][0]['end']->format('Y-m-d'));
        $this->assertSame('Hello world', $result['judgements'][0]['description']);
        
        // Limitations
        $this->assertArrayHasKey('limitations', $result);
        $this->assertCount(0, $result['limitations']);
    }
}
