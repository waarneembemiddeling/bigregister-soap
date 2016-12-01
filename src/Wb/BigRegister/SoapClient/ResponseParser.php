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
                        $specialism['name'] = $this->getSpecialism($row->TypeOfSpecialismId);
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
            '81' => 'Physician assistants',
            '82' => 'Klinisch technologen',
            '83' => 'Apothekersassistenten',
            '84' => 'Klinisch Fysici',
            '85' => 'Tandprothetici',
            '86' => 'Verzorgenden individuele gezondheidszorg',
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
            '99' => 'Onbekend'
        );

        if (isset($list[$code])) {
            return $list[$code];
        }
    }

    protected function getSpecialism($code)
    {
        $list = array(
            2 => 'Allergologie (allergoloog)',
            3 => 'Anesthesiologie (anesthesioloog)',
            4 => 'Huisartsgeneeskunde met apotheek (Apoth. Huisarts)',
            8 => 'Arbeid en gezond - bedrijfsgeneeskunde',
            10 => 'Cardiologie (cardioloog)',
            11 => 'Cardio-thoracale chirurgie',
            12 => 'Dermatologie en venerologie (dermatoloog)',
            13 => 'Maag-darm-leverziekten (maag-darm-leverarts)',
            14 => 'Heelkunde (chirurg)',
            15 => 'Huisartsgeneeskunde (huisarts)',
            16 => 'Interne geneeskunde (internist)',
            18 => 'Keel-, neus- en oorheelkunde (kno-arts)',
            19 => 'Kindergeneeskunde (kinderarts)',
            20 => 'Klinische chemie (arts klinische chemie)',
            21 => 'Klinische genetica (klinisch geneticus)',
            22 => 'Klinische geriatrie (klinisch geriater)',
            23 => 'Longziekten en tuberculose (longarts)',
            24 => 'Medische microbiologie (arts-microbioloog)',
            25 => 'Neurochirurgie (neurochirurg)',
            26 => 'Neurologie (neuroloog)',
            30 => 'Nucleaire geneeskunde (nucleair geneeskundige)',
            31 => 'Oogheelkunde (oogarts)',
            32 => 'Orthopedie (orthopeed)',
            33 => 'Pathologie (patholoog)',
            34 => 'Plastische chirurgie (plastisch chirurg)',
            35 => 'Psychiatrie (psychiater)',
            39 => 'Radiologie (radioloog)',
            40 => 'Radiotherapie (radiotherapeut)',
            41 => 'Reumatologie (reumatoloog)',
            42 => 'Revalidatiegeneeskunde (revalidatiearts)',
            43 => 'Maatschappij en gezondheid',
            45 => 'Urologie (uroloog)',
            46 => 'Obstetrie en gynaecologie (gynaecoloog)',
            47 => 'Specialisme ouderengeneeskunde',
            48 => 'Arbeid en gezondheid - verzekeringsgeneeskunde',
            50 => 'Zenuw- en zielsziekten (zenuwarts)',
            53 => 'Dento-maxillaire orthopaedie (orthodontist)',
            54 => 'Mondziekten en kaakchirurgie (kaakchirurg)',
            55 => 'Maatschappij en gezondheid',
            56 => 'Geneeskunde voor verstandelijk gehandicapten',
            60 => 'Ziekenhuisfarmacie (ziekenhuisapotheker)',
            61 => 'Klinische psychologie (klinisch psycholoog)',
            62 => 'Interne geneeskunde-allergologie',
            63 => 'Klinische neuropsychologie',
            65 => 'Verpl. spec. prev. zorg bij som. aandoeningen',
            66 => 'Verpl. spec. acute zorg bij som. aandoeningen',
            67 => 'Verpl. spec. intensieve zorg bij som. aandoeningen',
            68 => 'Verpl. spec. chronische zorg bij som. aandoeningen',
            69 => 'Verpl. spec. geestelijke gezondheidszorg',
            70 => 'Jeugdgezondheidszorg (Profiel KNMG Jeugdarts)',
            71 => 'Spoedeisendehulp (Profiel SEH Arts KNMG)',
            74 => 'Sportgeneeskunde',
            75 => 'Openbare Farmacie',
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
