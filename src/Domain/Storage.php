<?php
declare(strict_types=1);

namespace Argo\Domain;

interface Storage
{
    public function app(string $id) : string;

    public function path(string $id = '') : string;

    public function glob(string $pattern) : array;

    public function read(string $id) : ?string;

    public function write(string $id, string $text) : void;

    public function forceDir(string $id) : string;

    public function move(string $sourceId, string $targetId) : bool;

    public function trash(string $sourceId) : bool;

    public function exists(string $id) : bool;
}
