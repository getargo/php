<?php
declare(strict_types=1);

namespace Argo\UseCase\Site;

use Argo\Infrastructure\System;

class BuildSiteTest extends \Argo\UseCase\TestCase
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
