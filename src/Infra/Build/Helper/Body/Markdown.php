<?php
declare(strict_types=1);

namespace Argo\Infra\Build\Helper\Body;

use League\CommonMark\CommonMarkConverter;

class Markdown extends Markup
{
    protected $markdown;

    public function __construct()
    {
        $this->markdown = new CommonMarkConverter();
    }

    public function toHtml(string $body) : string
    {
        return (string) @$this->markdown->convertToHtml($body);
    }
}
