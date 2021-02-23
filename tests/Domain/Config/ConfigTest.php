<?php
declare(strict_types=1);

namespace Argo\Domain\Config;

class ConfigTest extends \Argo\Domain\TestCase
{
    protected function newFake(array $data)
    {
        return new Config('_argo/fake', (object) $data);
    }

    public function test__magic()
    {
        $fake = $this->newFake(['foo' => 'bar']);
        $this->assertSame('bar', $fake->foo);
        $fake->baz = 'dib';
        $this->assertSame('dib', $fake->baz);
        unset($fake->foo);
        $this->assertFalse(isset($fake->foo));
    }

    public function testGetText()
    {
        $expect = ['foo' => 'bar'];
        $fake = $this->newFake($expect);
        $actual = $fake->getText();
        $this->assertJsonEquals($expect, $actual);
    }

    public function testGetData()
    {
        $expect = ['foo' => 'bar'];
        $fake = $this->newFake($expect);
        $actual = $fake->getData();
        $this->assertEquals((object) $expect, $actual);
    }

    public function testGetIterator()
    {
        $expect = [
            'foo' => 'bar',
            'baz' => 'dib',
            'zim' => 'gir',
        ];

        $fake = $this->newFake($expect);
        foreach ($fake as $key => $val) {
            $this->assertSame($expect[$key], $val);
        }
    }
}
