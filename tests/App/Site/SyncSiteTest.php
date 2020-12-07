<?php
declare(strict_types=1);

namespace Argo\App\Site;

use Argo\Infra\System;

class SyncSiteTest extends \Argo\App\TestCase
{
    protected function setUp() : void
    {
        parent::setUp();
        $this->setUpArgo();
    }

    public function testInvalid() : void
    {
        $this->markTestIncomplete('need a way to test invalid sync config');

        $sync = $this->config->sync;

        unset($sync->type);
        $payload = $this->invoke();
        $this->assertInvalid($payload, "No sync type specified.");

        $sync->type = null;
        $payload = $this->invoke();
        $this->assertInvalid($payload, "No sync type specified.");

        $sync->type = '   ';
        $payload = $this->invoke();
        $this->assertInvalid($payload, "No sync type specified.");

        $sync->type = 'nonesuch';
        $payload = $this->invoke();
        $this->assertInvalid($payload, "Sync type 'nonesuch' not recognized.");
    }

    public function testProcessing_git() : void
    {
        $this->config->sync->type = 'git';

        $payload = $this->invoke();
        $this->assertProcessing($payload);

        // @todo: review $result->command value?
    }

    public function testSuccess_rsync() : void
    {
        $this->config->sync->type = 'rsync';
        $this->config->sync->host = 'example.com';
        $this->config->sync->user = 'boshag';
        $this->config->sync->path = '/var/www/html';

        $payload = $this->invoke();
        $this->assertProcessing($payload);

        // @todo: review $result->command value?
    }
}
