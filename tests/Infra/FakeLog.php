<?php
declare(strict_types=1);

namespace Argo\Infra;

use Argo\Infra\Log;
use Psr\Log\AbstractLogger;
use Psr\Log\LogLevel;
use Stringable;

class FakeLog extends Stdlog
{
    public function __construct()
    {
        $this->stdout = fopen('php://memory', 'w');
        $this->stderr = fopen('php://memory', 'w');
    }

    public function getStdout()
    {
        return $this->stdout;
    }

    public function getStderr()
    {
        return $this->stderr;
    }

    public function echo(Stringable|string $message, array $context = []) : void
    {
        $handle = $this->stdout;
        fwrite($handle, $this->interpolate($message, $context));
    }
}
