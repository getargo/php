<?php
declare(strict_types=1);

namespace Argo\UseCase;

use Argo\Domain\Storage;
use Argo\Infrastructure\System;
use Argo\UseCase\Payload;
use Argo\UseCase\UseCase;

class OpenFolder extends UseCase
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
