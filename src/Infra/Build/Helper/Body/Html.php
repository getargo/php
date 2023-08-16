<?php
declare(strict_types=1);

namespace Argo\Infra\Build\Helper\Body;

class Html extends Markup
{
    public function toHtml(string $body) : string
    {
        return $body;
    }
}
