<?php
declare(strict_types=1);

namespace Argo\App;

class DashboardTest extends \Argo\App\TestCase
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
