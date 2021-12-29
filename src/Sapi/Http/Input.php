<?php
declare(strict_types=1);

namespace Argo\Sapi\Http;

class Input
{
    static public function implode(array $parts) : string
    {
        return trim(implode('/', $parts), '/');
    }
}
