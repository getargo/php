<?php
declare(strict_types=1);

namespace Argo\Infra\Template\Helper\Body;

abstract class Markup
{
    abstract public function toHtml(string $body) : string;
}
