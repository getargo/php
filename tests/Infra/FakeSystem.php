<?php
declare(strict_types=1);

namespace Argo\Infra;

use Argo\Domain\Log;

class FakeSystem extends System
{
    public $timezone = 'UTC';

    public $command;

    public function timezone() : string
    {
        return $this->timezone;
    }

    public function exec(string $cmd, Log $log = null, string $level = null) : void
    {
        $this->cmd = $cmd;
    }

    public function homeDir() : string
    {
        return dirname(__DIR__) . '/tmp';
    }

    public function docroot() : string
    {
        return $this->sitesDir() . '/argo-test';
    }
}
