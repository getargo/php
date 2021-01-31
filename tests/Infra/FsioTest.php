<?php
declare(strict_types=1);

namespace Argo\Infra;

use Argo\Domain\DateTime;
use RuntimeException;

class FsioTest extends \Argo\TestCase
{
    protected $root;

    protected function setUp() : void
    {
        parent::setUp();
        $this->root = dirname(__DIR__) . '/tmp';
        $this->fsio = new Fsio(
            new System(new FakeLog()),
            new DateTime(),
            $this->root
        );
    }

    public function testPath() : void
    {
        $expect = "{$this->root}/foo/bar";
        $actual = $this->fsio->path('foo/bar');
        $this->assertSame($expect, $actual);

        $this->expectException(RuntimeException::CLASS);
        $this->expectExceptionMessage("Double-dots not allowed in IDs");
        $this->fsio->path('foo/../../bar');
    }

    public function testReadWrite() : void
    {
        $id = 'foo/bar';
        $expect = uniqid() . "\n";
        $this->fsio->write("{$id}/argo.json", $expect);
        $actual = $this->fsio->read("{$id}/argo.json");
        $this->assertSame($expect, $actual);
    }
}
