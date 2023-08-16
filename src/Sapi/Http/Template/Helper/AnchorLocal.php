<?php
declare(strict_types=1);

namespace Argo\Sapi\Http\Template\Helper;

use Qiq\Helper\Html\Anchor;

class AnchorLocal
{
    protected $anchor;

    public function __construct(Anchor $anchor)
    {
        $this->anchor = $anchor;
    }

    public function __invoke(string $href, string $text, array $attr = [], mixed ...$__attr) : string
    {
        $href = ltrim($href, '/');
        return ($this->anchor)("http://127.0.0.1:8081/{$href}", $text, $attr, ...$__attr);
    }
}
