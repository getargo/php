<?php
declare(strict_types=1);

namespace Argo\Infra;

use Stringable;
use Psr\Log\LoggerInterface;

interface Log extends LoggerInterface
{
    public function echo(Stringable|string $message, array $context = []) : void;
}
