<?php
declare(strict_types=1);

namespace Argo\View\Helper;

use Aura\Html\Escaper;
use Aura\Html\Helper\Anchor;

class AnchorLocal
{
    protected $anchor;

    public function __construct(
        Escaper $escaper,
        Anchor $anchor
    ) {
        $this->escaper = $escaper;
        $this->anchor = $anchor;
    }

    public function __invoke(string $href, string $text, array $attr = [])
    {
        $href = ltrim($href, '/');
        return ($this->anchor)("http://127.0.0.1:8081/{$href}", $text, $attr);
    }
}
