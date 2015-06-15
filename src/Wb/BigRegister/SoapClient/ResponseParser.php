<?php
/*
* (c) Waarneembemiddeling.nl
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Wb\BigRegister\SoapClient;

use Wb\BigRegister\SoapClient\Model\ListHcpApproxResponse4;

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
                        $article['profession'] = $this->getProfession($registration->ProfessionalGroupCode);

                        $return['articles'][] = $article;
                    }
                }

                if (isset($hcpResult->Specialism->SpecialismExtApp)) {
                    foreach ($hcpResult->Specialism->SpecialismExtApp as $row) {
                        $specialism = array();
                        $specialism['bigNumber'] = $row->ArticleRegistrationNumber;
                        $specialism['start'] = new \DateTime($row->StartDate);
                        $specialism['end'] = null;
                        if ($row->EndDate) {
                            $specialism['end'] = new \DateTime($row->EndDate);
                        }
                        $specialism['name'] = $this->getSpecialism($row->TypeOfSpecialismId);
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

    protected function getProfession($code)
    {
        $list = array(
            '01' => 'Artsen',
            '02' => 'Tandartsen',
            '03' => 'Verloskundigen',
            '04' => 'Fysiotherapeuten',
            '16' => 'Psychotherapeuten',
            '17' => 'Apothekers',
            '18' => 'Apotheekhoudende artsen',
            '25' => 'Gz-psychologen',
            '30' => 'Verpleegkundigen',
            '87' => 'Optometristen',
            '88' => 'Huidtherapeuten',
            '89' => 'Diëtisten',
            '90' => 'Ergotherapeuten',
            '91' => 'Logopedisten',
            '92' => 'Mondhygiënisten',
            '93' => 'Oefentherapeuten Mensendieck',
            '94' => 'Oefentherapeuten Cesar',
            '95' => 'Orthoptisten',
            '96' => 'Podotherapeuten',
            '97' => 'Radiodiagnostisch laboranten',
            '98' => 'Radiotherapeutisch laboranten',
            '99' => 'Onbekend',
            '83' => 'Apothekersassistenten',
            '85' => 'Tandprothetica',
            '86' => 'Verzorgenden individuele gezondheidszorg'
        );
        if (isset($list[$code])) {
            return $list[$code];
        }
    }

    protected function getSpecialism($code)
    {
        $list = array(
            2 => 'allergologie',
            3 => 'anesthesiologie',
            4 => 'algemene gezondheidszorg',
            5 => 'medische milieukunde',
            6 => 'tuberculosebestrijding',
            7 => 'arbeid en gezondheid',
            8 => 'arbeid en gezondheid - bedrijfsgeneeskunde',
            10 => 'cardiologie',
            11 => 'cardio-thoracale chirurgie',
            12 => 'dermatologie en venerologie',
            13 => 'leer van maag-darm-leverziekten',
            14 => 'heelkunde',
            15 => 'huisartsgeneeskunde',
            16 => 'inwendige geneeskunde',
            17 => 'jeugdgezondheidszorg',
            18 => 'keel- neus- oorheelkunde',
            19 => 'kindergeneeskunde',
            20 => 'klinische chemie',
            21 => 'klinische genetica',
            22 => 'klinische geriatrie',
            23 => 'longziekten en tuberculose',
            24 => 'medische microbiologie',
            25 => 'neurochirurgie',
            26 => 'neurologie',
            30 => 'nucleaire geneeskunde',
            31 => 'oogheelkunde',
            32 => 'orthopedie',
            33 => 'pathologie',
            34 => 'plastische chirurgie',
            35 => 'psychiatrie',
            39 => 'radiologie',
            40 => 'radiotherapie',
            41 => 'reumatologie',
            42 => 'revalidatiegeneeskunde',
            43 => 'maatschappij en gezondheid',
            44 => 'sportgeneeskunde',
            45 => 'urologie',
            46 => 'obstetrie en gynaecologie',
            47 => 'verpleeghuisgeneeskunde',
            48 => 'arbeid en gezondheid - verzekeringsgeneeskunde',
            50 => 'zenuw- en zielsziekten',
            53 => 'dento-maxillaire orthopaedie',
            54 => 'mondziekten en kaakchirurgie',
            55 => 'maatschappij en gezondheid',
            56 => 'medische zorg voor verstandelijke gehandicapten',
            60 => 'ziekenhuisfarmacie',
            61 => 'klinische psychologie',
            62 => 'interne geneeskunde-allergologie',
        );
        if (isset($list[$code])) {
            return $list[$code];
        }
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
