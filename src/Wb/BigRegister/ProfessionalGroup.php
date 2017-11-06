<?php

namespace Wb\BigRegister;

class ProfessionalGroup
{
    public static function getAll()
    {
        return array(
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
    }

    public static function valueOf($profession)
    {
        $professions = self::getAll();

        $code = array_search($profession, $professions, true);
        return $code === false ? null : $code;
    }

    public static function nameOf($code)
    {
        $professions = self::getAll();

        if (array_key_exists($code, $professions)) {
            return $professions[$code];
        }

        return null;
    }
}
