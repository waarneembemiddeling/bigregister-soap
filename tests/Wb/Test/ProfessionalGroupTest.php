<?php

namespace Wb\Test;

use PHPUnit\Framework\TestCase;
use Wb\BigRegister\ProfessionalGroup;

class ProfessionalGroupTest extends TestCase
{
    public function testGetAll()
    {
        $specialisms = ProfessionalGroup::getAll();

        self::assertInternalType('array', $specialisms);
        self::assertGreaterThan(0, count($specialisms));
    }

    public function testCanGetValueOf()
    {
        self::assertEquals('01', ProfessionalGroup::valueOf('Artsen'));
        self::assertEquals('02', ProfessionalGroup::valueOf('Tandartsen'));
        self::assertEquals(null, ProfessionalGroup::valueOf('NotExistentProfession'));
    }

    public function testCanGetNameOf()
    {
        self::assertEquals('Artsen', ProfessionalGroup::nameOf('01'));
        self::assertEquals('Tandartsen', ProfessionalGroup::nameOf('02'));
    }
}
