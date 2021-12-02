<?php
declare(strict_types=1);

namespace Argo\Domain\App;

use Argo\Domain\Storage;
use Argo\Infra\System;
use Argo\Domain\Payload;
use Argo\Domain\App;

class OpenFolder extends App
{
    protected $storage;

    protected $system;

    public function __construct(System $system, Storage $storage)
    {
        $this->system = $system;
        $this->storage = $storage;
    }

    protected function exec(string $id) : Payload
    {
        $path = $this->storage->path($id);
        $folder = realpath($path);

        if ($folder === false || ! is_dir($folder)) {
            return Payload::error([
                'error' => "Folder '$path' not found.",
            ]);
        }

        $this->system->open($folder);

        return Payload::accepted();
    }
}
