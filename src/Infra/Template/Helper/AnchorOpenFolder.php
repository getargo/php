<?php
declare(strict_types=1);

namespace Argo\Infra\Template\Helper;

use Qiq\Escape;
use Qiq\Helper\Anchor;
use Qiq\Helper\Helper;

class AnchorOpenFolder extends Helper
{
    protected $anchor;

    public function __construct(
        Escape $escape,
        Anchor $anchor
    ) {
        parent::__construct($escape);
        $this->anchor = $anchor;
    }

    public function __invoke(string $id, string $text = 'Open Folder') : string
    {
        $id = $this->escape->j($id);
        return ($this->anchor)('', $text, [
            'onclick' => "return openFolder('{$id}');",
        ]);
    }
}
