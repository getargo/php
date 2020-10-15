<?php
declare(strict_types=1);

namespace Argo\Domain\Config\Values;

class ValuesTest extends \Argo\Domain\TestCase
{
    public function test__magic()
    {
        $fake = new Fake((object) ['foo' => 'bar']);
        $this->assertSame('bar', $fake->foo);
        $fake->baz = 'dib';
        $this->assertSame('dib', $fake->baz);
        unset($fake->foo);
        $this->assertFalse(isset($fake->foo));
    }

    public function testGetText()
    {
        $expect = ['foo' => 'bar'];
        $fake = new Fake((object) $expect);
        $actual = $fake->getText();
        $this->assertJsonEquals($expect, $actual);
    }

    public function testGetData()
    {
        $expect = (object) ['foo' => 'bar'];
        $fake = new Fake($expect);
        $actual = $fake->getData();
        $this->assertSame($expect, $actual);
    }

    public function testGetIterator()
    {
        $expect = (object) [
            'foo' => 'bar',
            'baz' => 'dib',
            'zim' => 'gir',
        ];

        $fake = new Fake($expect);
        foreach ($fake as $key => $val) {
            $this->assertSame($expect->$key, $val);
        }
    }
}
