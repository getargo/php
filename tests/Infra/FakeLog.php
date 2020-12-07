<?php
declare(strict_types=1);

namespace Argo\Infra;

use Argo\Domain\Log;
use Psr\Log\AbstractLogger;
use Psr\Log\LogLevel;

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

    public function echo($message, array $context = [])
    {
        $handle = $this->stdout;
        fwrite($handle, $this->interpolate($message, $context));
    }
}
