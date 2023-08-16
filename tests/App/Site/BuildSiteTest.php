<?php
declare(strict_types=1);

namespace Argo\App\Site;

use Argo\Infra\System;

class BuildSiteTest extends \Argo\App\TestCase
{
    protected function setUp() : void
    {
        parent::setUp();
        $this->setUpArgo();
    }

    public function testSuccess() : void
    {
        $payload = $this->invoke();
        $this->assertAccepted($payload);
        // @todo assert the callable
    }
}
