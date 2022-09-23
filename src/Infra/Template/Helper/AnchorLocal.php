<?php
declare(strict_types=1);

namespace Argo\Infra\Template\Helper;

use Qiq\Escape;
use Qiq\Helper\Anchor;
use Qiq\Helper\Helper;

class AnchorLocal extends Helper
{
    protected $anchor;

    public function __construct(
        Escape $escape,
        Anchor $anchor
    ) {
        parent::__construct($escape);
        $this->anchor = $anchor;
    }

    public function __invoke(string $href, string $text, array $attr = []) : string
    {
        $href = ltrim($href, '/');
        return ($this->anchor)("http://127.0.0.1:8081/{$href}", $text, $attr);
    }
}
