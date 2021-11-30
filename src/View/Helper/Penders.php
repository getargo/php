<?php
declare(strict_types=1);

namespace Argo\View\Helper;

use Qiq\Template;

class Penders
{
    public function __invoke(Template $tpl, string $type) : string
    {
        $html = '';

        foreach ($tpl->penders[$type] ?? [] as $name) {
            $html .= $tpl->render("penders/{$type}/{$name}");
        }

        return $html;
    }
}
