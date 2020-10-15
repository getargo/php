<?php
declare(strict_types=1);

namespace Argo\Domain;

class JsonTest extends \Argo\Domain\TestCase
{
    public function testRecode()
    {
        $expect = ['foo' => 'bar'];

        $actual = Json::recode($expect);
        $this->assertTrue(is_object($actual));
        $this->assertSame($expect, (array) $actual);

        $actual = Json::recode($actual, true);
        $this->assertTrue(is_array($actual));
        $this->assertSame($expect, $actual);
    }
}
