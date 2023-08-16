<?php
declare(strict_types=1);

namespace Argo\Sapi\Http\Template\Helper;

use Qiq\Helper\Html\Anchor;
use Qiq\Helper\Html\Escape;

class AnchorOpenFolder
{
    protected $anchor;

    protected $escape;

    public function __construct(
        Escape $escape,
        Anchor $anchor
    ) {
        $this->escape = $escape;
        $this->anchor = $anchor;
    }

    public function __invoke(string $id, string $text = 'Open Folder') : string
    {
        $id = $this->escape->j($id);
        return ($this->anchor)(
            '',
            $text,
            onclick: "return openFolder('{$id}');",
        );
    }
}
