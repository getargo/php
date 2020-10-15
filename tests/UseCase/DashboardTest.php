<?php
declare(strict_types=1);

namespace Argo\UseCase;

class DashboardTest extends \Argo\UseCase\TestCase
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
