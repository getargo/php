<?php
declare(strict_types=1);

namespace Argo\Domain\Model\Content\Draft;

class DraftTest extends \Argo\Domain\TestCase
{
    public function testAssertId() : void
    {
        Draft::assertId('_draft/00010101T123456');
        $this->assertTrue(true);
    }

    public function testAssertIdException() : void
    {
        $this->expectInvalidData('Draft ID is not valid');
        Draft::assertId('foo');
    }

    public function testAbsId() : void
    {
        $relId = '00010101T123456';
        $expect = '_draft/00010101T123456';
        $actual = Draft::absId($relId);
        $this->assertSame($expect, $actual);
    }
}
