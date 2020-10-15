<?php
declare(strict_types=1);

namespace Argo\View\Helper;

use Aura\Html\Escaper;
use Aura\Html\Helper\Anchor;

class AnchorOpenFolder
{
    protected $anchor;

    public function __construct(
        Escaper $escaper,
        Anchor $anchor
    ) {
        $this->escaper = $escaper;
        $this->anchor = $anchor;
    }

    public function __invoke(string $id, string $text = 'Open Folder') : string
    {
        $id = $this->escaper->js($id);
        return ($this->anchor)('', $text, [
            'onclick' => "return openFolder('{$id}');",
        ]);
    }
}
