<?php
declare(strict_types=1);

namespace Argo\Domain\App;

class DashboardTest extends \Argo\Domain\App\TestCase
{
    protected function setUp() : void
    {
        parent::setUp();
        $this->setUpArgo();
    }

    public function testFound() : void
    {
        $payload = $this->invoke();
        $this->assertFound($payload);
    }
}
