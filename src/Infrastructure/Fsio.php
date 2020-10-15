<?php
declare(strict_types=1);

namespace Argo\Infrastructure;

use Argo\Domain\DateTime;
use Argo\Domain\Storage;
use RuntimeException;

class Fsio implements Storage
{
    static public function mkdir(string $dir) : void
    {
        $level = error_reporting(0);
        $result = mkdir($dir, 0755, true);
        error_reporting($level);

        if ($result !== false) {
            return;
        }

        $error = error_get_last();
        throw new RuntimeException($error['message'] . ": {$dir}");
    }

    protected $approot;

    protected $dateTime;

    protected $docroot;

    public function __construct(
        DateTime $dateTime,
        string $docroot
    ) {
        $this->dateTime = $dateTime;
        $this->approot = rtrim(dirname(__DIR__, 2), '/') . '/';
        $this->docroot = rtrim($docroot, '/') . '/';
    }

    public function app(string $id) : string
    {
        if (strpos($id, '..') !== false) {
            throw new RuntimeException("Double-dots not allowed in IDs: {$id}");
        }

        return $this->approot . ltrim($id, '/');
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
            static::mkdir($dir);
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
            static::mkdir($dir);
        }
        return $dir;
    }

    public function move(string $sourceId, string $targetId) : bool
    {
        $targetDir = $this->path($targetId);

        if (is_dir($targetDir)) {
            throw new RuntimeException("Directory already exists: {$targetDir}");
        }

        static::mkdir($targetDir);
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
}
