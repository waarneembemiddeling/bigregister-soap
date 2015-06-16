<?php
/*
* (c) Waarneembemiddeling.nl
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Wb\Test\BigRegister\SoapClient;

use Wb\BigRegister\SoapClient\Model\ListHcpApproxRequest;
use Wb\Test\SoapClientTestCase;

class ClientTest extends SoapClientTestCase
{
    public function testClassMapping()
    {
        $client = $this->getSoapClient();
        $request = new ListHcpApproxRequest();
        $request->RegistrationNumber = '123456789';
        $response = $client->ListHcpApprox4($request);

        $this->assertInstanceOf(
            'Wb\BigRegister\SoapClient\Model\ListHcpApproxResponse4',
            $response
        );
        $this->assertInstanceOf(
            'Wb\BigRegister\SoapClient\Model\ArrayOfListHcpApprox4',
            $response->ListHcpApprox
        );
        $this->assertInstanceOf(
            'Wb\BigRegister\SoapClient\Model\ListHcpApprox4',
            $response->ListHcpApprox->ListHcpApprox4[0]
        );
        $this->assertInstanceOf(
            'Wb\BigRegister\SoapClient\Model\ArrayOfArticleRegistrationExtApp',
            $response->ListHcpApprox->ListHcpApprox4[0]->ArticleRegistration
        );
        $this->assertInstanceOf(
            'Wb\BigRegister\SoapClient\Model\ArticleRegistrationExtApp',
            $response->ListHcpApprox->ListHcpApprox4[0]->ArticleRegistration->ArticleRegistrationExtApp[0]
        );
        $this->assertInstanceOf(
            'Wb\BigRegister\SoapClient\Model\ArrayOfSpecialismExtApp1',
            $response->ListHcpApprox->ListHcpApprox4[0]->Specialism
        );
        $this->assertInstanceOf(
            'Wb\BigRegister\SoapClient\Model\SpecialismExtApp1',
            $response->ListHcpApprox->ListHcpApprox4[0]->Specialism->SpecialismExtApp1[0]
        );
        $this->assertInstanceOf(
            'Wb\BigRegister\SoapClient\Model\ArrayOfMentionExtApp',
            $response->ListHcpApprox->ListHcpApprox4[0]->Mention
        );
        $this->assertInstanceOf(
            'Wb\BigRegister\SoapClient\Model\ArrayOfJudgmentProvisionExtApp',
            $response->ListHcpApprox->ListHcpApprox4[0]->JudgmentProvision
        );
        $this->assertInstanceOf(
            'Wb\BigRegister\SoapClient\Model\JudgmentProvisionExtApp',
            $response->ListHcpApprox->ListHcpApprox4[0]->JudgmentProvision->JudgmentProvisionExtApp[0]
        );
    }
}
