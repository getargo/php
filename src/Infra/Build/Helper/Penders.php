<?php
declare(strict_types=1);

namespace Argo\Infra\Build\Helper;

use Argo\Infra\Build\Template;

class Penders
{
    public function __invoke(Template $tpl, string $type) : string
    {
        $html = '';
        $data = $tpl->getData();

        foreach ($data['penders'][$type] ?? [] as $name) {
            $html .= $tpl->render("penders/{$type}/{$name}");
        }

        return $html;
    }
}
