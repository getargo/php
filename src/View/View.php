<?php
declare(strict_types=1);

namespace Argo\View;

class View extends \Aura\View\View
{
    protected function renderAll(array $names, array $vars = [])
    {
        $html = '';

        foreach ($names as $name) {
            $html .= $this->render($name, $vars);
        }

        return $html;
    }
}
