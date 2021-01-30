<?php
declare(strict_types=1);

namespace Argo\Infra;

use Argo\Domain\Log;

class FakeSystem extends System
{
    public $timezone = 'UTC';

    public function timezone() : string
    {
        return $this->timezone;
    }

    public function homeDir() : string
    {
        return dirname(__DIR__) . '/tmp';
    }

    public function docroot() : string
    {
        return $this->sitesDir() . '/argo-test';
    }

    public function open(string $file) : void
    {
        // do nothing
    }
}
