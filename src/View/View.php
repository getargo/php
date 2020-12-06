<?php
declare(strict_types=1);

namespace Argo\View;

class View extends \Aura\View\View
{
    protected function penders(string $type) : string
    {
        $html = '';

        foreach ($this->penders[$type] ?? [] as $name) {
            $html .= $this->render("penders/{$type}/{$name}");
        }

        return $html;
    }
}
