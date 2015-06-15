<?php
/*
* (c) Waarneembemiddeling.nl
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Wb\Test;

use Wb\BigRegister\SoapClient\Model\ArrayOfArticleRegistrationExtApp;
use Wb\BigRegister\SoapClient\Model\ArrayOfJudgmentProvisionExtApp;
use Wb\BigRegister\SoapClient\Model\ArrayOfLimitationExtApp;
use Wb\BigRegister\SoapClient\Model\ArrayOfListHcpApprox3;
use Wb\BigRegister\SoapClient\Model\ArrayOfMentionExtApp;
use Wb\BigRegister\SoapClient\Model\ArrayOfSpecialismExtApp;
use Wb\BigRegister\SoapClient\Model\ArticleRegistrationExtApp;
use Wb\BigRegister\SoapClient\Model\ListHcpApprox4;
use Wb\BigRegister\SoapClient\Model\ListHcpApproxResponse4;
use Wb\BigRegister\SoapClient\Model\SpecialismExtApp;

class SoapClientTestCase extends \PHPUnit_Framework_TestCase
{
    public function getMockSoapClient()
    {
        $bigSoapClient = $this->getMockFromWsdl(
            __DIR__.'/../../../resources/bigregister.wsdl',
            'Wb\BigRegister\SoapClient\Client',
            '',
            array(
                'ListHcpApprox4'
            )
        );

        $data = array(
            'hcp'           => '1234',
            'birthSurname'  => 'Jansen',
            'mailingName'   => 'J.J. van der Jansen',
            'initial'       => 'J.J.',
            'prefix'        => 'van der',
            'gender'        => 'V',
            'number'        => '123456789',
            'start'         => '2009-02-06T00:00:00',
            'end'           => '0001-01-01T00:00:00',
            'groupCode'     => '01',
            'specialisms'   => array(
                array(
                    'specialismId'      => '17795',
                    'start'             => '1998-12-10T00:00:00',
                    'end'               => null,
                    'typeOfSpecialismId'=> '15',
                    'number'            => '123456789',
                ),
                array(
                    'specialismId'      => '29656',
                    'start'             => '2001-02-16T00:00:00',
                    'end'               => null,
                    'typeOfSpecialismId'=> '56',
                    'number'            => '123456789',
                )
            )
        );

        $resp = $this->createResponse($data);
        $bigSoapClient->expects($this->any())
            ->method('ListHcpApprox4')
            ->will($this->returnValue($resp));

        return $bigSoapClient;
    }

    private function createResponse(array $data)
    {
        $resp = $this->createListHcpApprox3(
            $data['hcp'], $data['birthSurname'], $data['mailingName'], $data['initial'], $data['prefix'], $data['gender']
        );
        $resp->ArticleRegistration = new ArrayOfArticleRegistrationExtApp();
        $resp->ArticleRegistration->ArticleRegistrationExtApp[] = $this->createArticleRegistration(
            $data['number'], $data['start'], $data['end'], $data['groupCode']
        );
        $resp->Specialism = new ArrayOfSpecialismExtApp();
        foreach ($data['specialisms'] as $specialism) {
            $resp->Specialism->SpecialismExtApp[] = $this->createSpecialismExtApp(
                $specialism['specialismId'], $specialism['number'], $specialism['start'], $specialism['end'], $specialism['typeOfSpecialismId']
            );
        }
        $resp->Mention = new ArrayOfMentionExtApp();
        $resp->JudgmentProvision = new ArrayOfJudgmentProvisionExtApp();
        $resp->Limitation = new ArrayOfLimitationExtApp();

        $return = new ListHcpApproxResponse4();
        $return->ListHcpApprox = new ArrayOfListHcpApprox3();
        $return->ListHcpApprox->ListHcpApprox3 = array(
            $resp
        );
        return $return;
    }

    private function createSpecialismExtApp($specialismId, $number, $start, $end, $typeOfSpecialismId)
    {
        $r = new SpecialismExtApp();
        $r->SpecialismId = $specialismId;
        $r->ArticleRegistrationNumber = $number;
        $r->StartDate = $start;
        $r->EndDate = $end;
        $r->TypeOfSpecialismId = $typeOfSpecialismId;

        return $r;
    }

    private function createArticleRegistration($number, $start, $end, $groupCode)
    {
        $a = new ArticleRegistrationExtApp();
        $a->ArticleRegistrationNumber = $number;
        $a->ArticleRegistrationStartDate = $start;
        $a->ArticleRegistrationEndDate = $end;
        $a->ProfessionalGroupCode = $groupCode;

        return $a;
    }

    private function createListHcpApprox3($hcp, $birthSurname, $mailingName, $initial, $prefix, $gender)
    {
        $r = new ListHcpApprox4();
        $r->HcpNumber = $hcp;
        $r->BirthSurname = $birthSurname;
        $r->MailingName = $mailingName;
        $r->Initial = $initial;
        $r->Prefix = $prefix;
        $r->Gender = $gender;

        return $r;
    }
} 
