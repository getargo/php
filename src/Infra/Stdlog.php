<?php
declare(strict_types=1);

namespace Argo\Infra;

use Argo\Infra\Log;
use Psr\Log\AbstractLogger;
use Psr\Log\LogLevel;
use Stringable;

class Stdlog extends AbstractLogger implements Log
{
    protected $stdout;

    protected $stderr;

    protected $stderrLevels = [
        LogLevel::EMERGENCY,
        LogLevel::ALERT,
        LogLevel::CRITICAL,
        LogLevel::ERROR,
    ];

    public static function console(string $message, ...$vars)
    {
        $log = new static();
        $log->debug($message);
        foreach ($vars as $var) {
            $log->debug(print_r($var, true));
        }
    }

    public function __construct($stdout = null, $stderr = null)
    {
        $this->stdout = $stdout ?? fopen('php://stdout', 'w');
        $this->stderr = $stderr ?? fopen('php://stderr', 'w');
    }

    public function echo(Stringable|string $message, array $context = []) : void
    {
        echo $this->interpolate($message, $context);
        flush();
    }

    public function log($level, Stringable|string $message, array $context = []) : void
    {
        $handle = $this->stdout;

        if (in_array($level, $this->stderrLevels)) {
            $handle = $this->stderr;
        }

        fwrite($handle, $this->interpolate($message, $context));
    }

    protected function interpolate($message, array $context) : string
    {
        if (is_array($message)) {
            $message = implode(PHP_EOL, $message);
        }

        $replace = [];
        foreach ($context as $key => $val) {
            $replace['{' . $key . '}'] = $val;
        }

        return strtr($message, $replace) . PHP_EOL;
    }
}
