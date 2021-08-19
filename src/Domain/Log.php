<?php
declare(strict_types=1);

namespace Argo\Domain;

use Stringable;

interface Log
{
    public function emergency(Stringable|string $message, array $context = []) : void;

    public function alert(Stringable|string $message, array $context = []) : void;

    public function critical(Stringable|string $message, array $context = []) : void;

    public function error(Stringable|string $message, array $context = []) : void;

    public function warning(Stringable|string $message, array $context = []) : void;

    public function notice(Stringable|string $message, array $context = []) : void;

    public function info(Stringable|string $message, array $context = []) : void;

    public function debug(Stringable|string $message, array $context = []) : void;

    public function echo(Stringable|string $message, array $context = []) : void;
}
