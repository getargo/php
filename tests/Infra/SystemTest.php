<?php
declare(strict_types=1);

namespace Argo\Infra;

class SystemTest extends \Argo\TestCase
{
    protected $home;

    protected $system;

    /**
     * @dataProvider provide
     */
    public function test(string $os, string $method, string $expect)
    {
        $system = new FakeSystem(new FakeLog(), $os);
        $actual = $system->$method();
        $this->assertSame($expect, $actual);
    }

    public function provide() : array
    {
        $home = dirname(__DIR__) . '/tmp';
        return [
            ['darwin', 'sitesDir', "{$home}/Sites"],
            ['darwin', 'supportDir', "{$home}/Library/Application Support/Argo"],
            ['linux', 'sitesDir', "{$home}/Sites"],
            ['linux', 'supportDir', "{$home}/.config/Argo"],
        ];
    }
}
