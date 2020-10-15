<?php
declare(strict_types=1);

namespace Argo\Infrastructure;

use Argo\Domain\Config\Config;
use Argo\Domain\Config\Values\Sync as SyncValues;
use Argo\Domain\Content\ContentLocator;
use Argo\Domain\Log;
use Argo\Domain\Storage;
use Argo\Infrastructure\System;

class Sync
{
    protected $config;

    protected $storage;

    protected $system;

    public function __construct(
        System $system,
        Storage $storage,
        Config $config,
        Log $log
    ) {
        $this->system = $system;
        $this->storage = $storage;
        $this->config = $config;
        $this->log = $log;
    }

    public function __invoke() : void
    {
        $sync = $this->config->sync;

        if (
            ! isset($sync->type)
            || ! is_string($sync->type)
            || trim($sync->type) === ''
        ) {
            $this->log->error('No sync type specified in config.');
            return;
        }

        $type = trim($sync->type);

        if (! method_exists($this, $type)) {
            $this->log->error("Sync type '$type' not recognized.");
            return;
        }

        $cmd = $this->$type($sync);
        $this->system->exec("{$cmd} 2>&1", $this->log, 'echo');
        $this->log->echo('Done!');
    }

    protected function rsync(SyncValues $sync) : string
    {
        return implode(" \\" . PHP_EOL . "  ", [
            "rsync",
            "-avz",
            "-e 'ssh -o StrictHostKeyChecking=no -o UserKnownHostsFile=/dev/null'",
            "--delete",
            "--delete-excluded",
            "--delete-after",
            "--progress",
            "--exclude='_*'",
            "--exclude='.DS_Store'",
            "--exclude='.git'",
            "--exclude='.gitignore'",
            "--chmod=ugo+rx",
            $this->storage->path('.'),
            "{$sync->user}@{$sync->host}:{$sync->path}",
        ]);
    }

    protected function git(Sync $sync) : string
    {
        return implode(" \\" . PHP_EOL, [
            "cd " . $this->storage->path(),
            "&& git add .",
            "&& git commit -a --message='sync site'",
            "&& git push"
        ]);
    }
}
