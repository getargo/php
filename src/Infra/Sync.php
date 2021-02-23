<?php
declare(strict_types=1);

namespace Argo\Infra;

use Argo\Domain\Config\ConfigMapper;
use Argo\Domain\Config\Values;
use Argo\Domain\Content\ContentLocator;
use Argo\Domain\DateTime;
use Argo\Domain\Log;
use Argo\Domain\Storage;
use Argo\Infra\System;

class Sync
{
    protected $dateTime;

    protected $config;

    protected $log;

    protected $storage;

    protected $system;

    public function __construct(
        System $system,
        Storage $storage,
        ConfigMapper $config,
        DateTime $dateTime,
        Log $log
    ) {
        $this->system = $system;
        $this->storage = $storage;
        $this->config = $config;
        $this->dateTime = $dateTime;
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
        $this->system->exec("{$cmd} 2>&1", 'echo');

        $this->config->admin->lastSync = $this->dateTime->utc();
        $this->config->save($this->config->admin);

        $this->log->echo('Done!');
    }

    protected function rsync(Values $sync) : string
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

    protected function git(Values $sync) : string
    {
        return implode(" \\" . PHP_EOL, [
            "cd " . $this->storage->path(),
            "&& git add .",
            "&& git commit -a --message='sync site'",
            "&& git push -u origin `git branch --show-current`"
        ]);
    }
}
