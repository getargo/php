<?php
declare(strict_types=1);

namespace Argo\Http;

use Argo\App\Payload;
use Argo\App\UseCase;
use Sapien\Request;
use Sapien\Response;

abstract class Action
{
    protected function implode(array $parts) : string
    {
        return trim(implode('/', $parts), '/');
    }
}
