<?php
declare(strict_types=1);

namespace Argo\Persistence;

use Argo\Domain\Model\DateTime;
use Argo\Domain\Storage;
use Argo\Infra\System;
use RuntimeException;

class Fsio implements Storage
{
    protected $system;

    protected $dateTime;

    protected $docroot;

    public function __construct(
        System $system,
        DateTime $dateTime,
        string $docroot
    ) {
        $this->system = $system;
        $this->dateTime = $dateTime;
        $this->docroot = rtrim($docroot, '/') . '/';
    }

    public function path(string $id = '') : string
    {
        if (strpos($id, '..') !== false) {
            throw new RuntimeException("Double-dots not allowed in IDs: {$id}");
        }

        return $this->docroot . ltrim($id, '/');
    }

    public function glob(string $pattern) : array
    {
        return glob($this->path($pattern));
    }

    public function read(string $id) : ?string
    {
        $file = $this->path($id);
        return file_exists($file)
            ? file_get_contents($file)
            : null;
    }

    public function write(string $id, string $text) : void
    {
        $file = $this->path($id);
        $dir = dirname($file);
        if (! is_dir($dir)) {
            $this->system->mkdir($dir);
        }

        $text = strtr($text, [
            "\r\n" => "\n",
            "\r" => "\n"
        ]);

        file_put_contents($file, trim($text) . "\n");

        chmod($file, 0755);
    }

    public function forceDir(string $id) : string
    {
        $dir = $this->path($id);
        if (! is_dir($dir)) {
            $this->system->mkdir($dir);
        }
        return $dir;
    }

    public function move(string $sourceId, string $targetId) : bool
    {
        $targetDir = $this->path($targetId);

        if (is_dir($targetDir)) {
            throw new RuntimeException("Directory already exists: {$targetDir}");
        }

        $this->system->mkdir($targetDir);
        $sourceDir = $this->path($sourceId);

        return rename($sourceDir, $targetDir);
    }

    public function trash(string $sourceId) : bool
    {
        $time = $this->dateTime->local(
            $this->dateTime->utc(),
            'Ymd\THis'
        );
        $targetId = "_trash/{$time}/{$sourceId}";
        return $this->move($sourceId, $targetId);
    }

    public function exists(string $id) : bool
    {
        return file_exists($this->path($id));
    }

    public function copy(string $sourceDir, string $targetId) : void
    {
        $targetDir = $this->forceDir($targetId);
        $this->system->exec("cp -rf {$sourceDir}/* {$targetDir}/");
    }
}
