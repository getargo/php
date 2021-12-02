<?php
declare(strict_types=1);

namespace Argo\Domain\App\Site;

use Argo\Infra\System;

class BuildSiteTest extends \Argo\Domain\App\TestCase
{
    protected function setUp() : void
    {
        parent::setUp();
        $this->setUpArgo();
    }

    public function testSuccess() : void
    {
        $payload = $this->invoke();
        $this->assertProcessing($payload);
        // @todo assert the callable
    }
}
