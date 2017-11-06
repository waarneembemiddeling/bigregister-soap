<?php
/*
* (c) Waarneembemiddeling.nl
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Wb\BigRegister\SoapClient;

use Wb\BigRegister\ProfessionalGroup;
use Wb\BigRegister\SoapClient\Model\ListHcpApproxResponse4;
use Wb\BigRegister\Specialism;

class ResponseParser
{
    public function parse(ListHcpApproxResponse4 $response)
    {
        $ret = array();
        if (isset($response->ListHcpApprox->ListHcpApprox4)) {
            foreach ($response->ListHcpApprox->ListHcpApprox4 as $hcpResult) {
                $return = array();
                $return['name'] = $hcpResult->MailingName;
                $return['prefix'] = $hcpResult->Prefix;
                $return['initial'] = $hcpResult->Initial;
                $return['birthSurname'] = $hcpResult->BirthSurname;
                $return['gender'] = $hcpResult->Gender === 'M' ? 'Man' : 'Vrouw';
                $return['articles'] = array();
                $return['specialisms'] = array();
                $return['mentions'] = array();
                $return['judgements'] = array();
                $return['limitations'] = array();
                if (isset($hcpResult->ArticleRegistration->ArticleRegistrationExtApp)) {
                    foreach ($hcpResult->ArticleRegistration->ArticleRegistrationExtApp as $registration) {
                        $article = array();
                        $article['bigNumber'] = $registration->ArticleRegistrationNumber;
                        $article['start'] = new \DateTime($registration->ArticleRegistrationStartDate);
                        $article['end'] = null;
                        if ($registration->ArticleRegistrationEndDate !== '0001-01-01T00:00:00') {
                            $article['end'] = new \DateTime($registration->ArticleRegistrationEndDate);
                        }
                        $article['profession'] = ProfessionalGroup::nameOf($registration->ProfessionalGroupCode);
                        $article['professionCode'] = $registration->ProfessionalGroupCode;

                        $return['articles'][] = $article;
                    }
                }

                if (isset($hcpResult->Specialism->SpecialismExtApp1)) {
                    foreach ($hcpResult->Specialism->SpecialismExtApp1 as $row) {
                        $specialism = array();
                        $specialism['bigNumber'] = $row->ArticleRegistrationNumber;
                        $specialism['start'] = null;
                        if ($row->StartDate) {
                            $specialism['start'] = new \DateTime($row->StartDate);
                        }
                        $specialism['end'] = null;
                        if ($row->EndDate) {
                            $specialism['end'] = new \DateTime($row->EndDate);
                        }
                        $specialism['name'] = Specialism::nameOf($row->TypeOfSpecialismId);
                        $specialism['code'] = $row->TypeOfSpecialismId;
                        $return['specialisms'][] = $specialism;
                    }
                }
                if (isset($hcpResult->Mention->MentionExtApp)) {
                    foreach ($hcpResult->Mention->MentionExtApp as $row) {
                        $mention = array();
                        $mention['bigNumber'] = $row->ArticleRegistrationNumber;
                        $mention['start'] = new \DateTime($row->StartDate);
                        $mention['end'] = null;
                        if ($row->EndDate) {
                            $mention['end'] = new \DateTime($row->EndDate);
                        }
                        $mention['name'] = $this->getMention($row->TypeOfMentionId);
                        $return['mentions'][] = $mention;
                    }
                }
                if (isset($hcpResult->JudgmentProvision->JudgmentProvisionExtApp)) {
                    foreach ($hcpResult->JudgmentProvision->JudgmentProvisionExtApp as $row) {
                        $judgement = array();
                        $judgement['bigNumber'] = $row->ArticleNumber;
                        $judgement['start'] = new \DateTime($row->StartDate);
                        $judgement['end'] = null;
                        if ($row->EndDate) {
                            $judgement['end'] = new \DateTime($row->EndDate);
                        }
                        $judgement['description'] = $row->PublicDescription;
                        $return['judgements'][] = $judgement;
                    }
                }
                if (isset($hcpResult->Limitation->LimitationExtApp)) {
                    foreach ($hcpResult->Limitation->LimitationExtApp as $row) {
                        $limitation = array();
                        $limitation['bigNumber'] = $row->ArticleRegistrationNumber;
                        $limitation['start'] = new \DateTime($row->StartDate);
                        $limitation['end'] = null;
                        if ($row->EndDate) {
                            $limitation['end'] = new \DateTime($row->EndDate);
                        }
                        $limitation['name'] = $this->getLimitation($row->TypeLimitationId);
                        $limitation['description'] = $row->Description;
                        $return['limitations'][] = $limitation;
                    }
                }

                $ret[] = $return;
            }
        }

        return $ret;
    }

    protected function getMention($code)
    {
        $list = array(
            1 => 'Voorschrijfbevoegdheid Astma en COPD',
            2 => 'Voorschrijfbevoegdheid Diabetes Mellitus',
            3 => 'Voorschrijfbevoegdheid Oncologie'
        );

        if (isset($list[$code])) {
            return $list[$code];
        }
    }

    protected function getLimitation($code)
    {
        $list = array(
            1 => 'Ongeclausuleerde inschrijving',
            2 => 'Geclausuleerde inschrijving voor bepaalde tijd',
            3 => 'Geclausuleerde inschrijving voor waarneming (bepaalde tijd)',
            4 => 'Geclausuleerde inschrijving voor onbepaalde tijd',
            5 => 'Clausule (conversie uit REGBIG)',
            6 => 'Geclausuleerde inschrijving (conversie uit REGBIG)',
        );

        if (isset($list[$code])) {
            return $list[$code];
        }
    }
} 
