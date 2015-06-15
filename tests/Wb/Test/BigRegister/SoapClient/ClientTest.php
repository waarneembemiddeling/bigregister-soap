<?php
/*
* (c) Waarneembemiddeling.nl
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Wb\Test\BigRegister\SoapClient;


use Wb\BigRegister\SoapClient\Client;
use Wb\BigRegister\SoapClient\Model\ListHcpApproxRequest;
use Wb\Test\SoapClientTestCase;

class ClientTest extends SoapClientTestCase
{
    public function testNumberSearch()
    {
        $request = new ListHcpApproxRequest();
        $request->RegistrationNumber = '123456789';

        $client = $this->getMockSoapClient();
        $response = $client->ListHcpApprox4($request);

        $this->assertInstanceOf('Wb\BigRegister\SoapClient\Model\ListHcpApproxResponse3', $response);
        $this->assertInternalType('array', $response->ListHcpApprox->ListHcpApprox3);
        $this->assertCount(1, $response->ListHcpApprox->ListHcpApprox3);
        $this->assertInstanceOf(
            'Wb\BigRegister\SoapClient\Model\ArrayOfArticleRegistrationExtApp',
            $response->ListHcpApprox->ListHcpApprox3[0]->ArticleRegistration
        );
        $article = $response->ListHcpApprox->ListHcpApprox3[0]->ArticleRegistration;
        $this->assertInternalType('array', $article->ArticleRegistrationExtApp);
        $this->assertInstanceOf(
            'Wb\BigRegister\SoapClient\Model\ArticleRegistrationExtApp',
            $article->ArticleRegistrationExtApp[0]
        );
        $this->assertSame('123456789', $article->ArticleRegistrationExtApp[0]->ArticleRegistrationNumber);
    }
} 
