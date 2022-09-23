<?php
declare(strict_types=1);

namespace Argo\Infra\Template\Helper\Body;

class Html extends Markup
{
    public function toHtml(string $body) : string
    {
        return $body;
    }
}
