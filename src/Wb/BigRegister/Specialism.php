<?php

namespace Wb\BigRegister;

class Specialism
{
    public static function getAll()
    {
        return array(
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
    }

    public static function valueOf($name)
    {
        $list = self::getAll();

        $index = array_search($name, $list, true);
        return $index !== false ? $index : null;
    }

    public static function nameOf($value)
    {
        $list = self::getAll();

        if (array_key_exists($value, $list)) {
            return $list[$value];
        }
        return null;
    }
}
