<?php
declare(strict_types=1);

namespace Argo\Infra;

use Argo\Infra\Log;

class Server
{
    protected $system;

    protected $log;

    public function __construct(
        System $system,
        Log $log
    ) {
        $this->system = $system;
        $this->log = $log;
    }

    public function start() : void
    {
        $pid = $this->pid();
        if ($pid === null) {
            $docroot = require $this->system->supportDir() . "/docroot.php";
            $cmd = "php -S 127.0.0.1:8081 -t {$docroot} &"; // echo $! > $support/pid
            $this->log->info($cmd);
            popen($cmd, 'r'); // DO NOT CLOSE
        }
    }

    public function stop(string $docroot = null) : void
    {
        $pid = $this->pid();

        if ($pid !== null) {
            $cmd = "kill {$pid}";
            $this->system->exec($cmd);
        }

        if ($docroot !== null) {
            $this->system->putDocroot($docroot);
        }
    }

    protected function pid() : ?int
    {
        exec(
            'ps -o command=COMMAND---------------,pid | grep "^php -S 127.0.0.1:8081"',
            $output
        );

        if (empty($output)) {
            return null;
        }

        $process = trim(array_shift($output));
        preg_match('/(\d+)$/', $process, $matches);
        return (int) $matches[1];
    }
}
