<?php

namespace Wb\Test;

use PHPUnit\Framework\TestCase;
use Wb\BigRegister\Specialism;

class SpecialismTest extends TestCase
{
    public function testGetAll()
    {
        $specialisms = Specialism::getAll();

        self::assertInternalType('array', $specialisms);
        self::assertGreaterThan(0, count($specialisms));
    }

    public function testCanGetValueOf()
    {
        self::assertEquals(2, Specialism::valueOf('Allergologie (allergoloog)'));
        self::assertEquals(3, Specialism::valueOf('Anesthesiologie (anesthesioloog)'));
        self::assertEquals(null, Specialism::valueOf('NonExistentSpecialism'));
    }

    public function testCanGetNameOf()
    {
        self::assertEquals('Allergologie (allergoloog)', Specialism::nameOf(2));
        self::assertEquals('Anesthesiologie (anesthesioloog)', Specialism::nameOf(3));
    }
}
