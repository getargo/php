<?php
namespace Argo\Bootstrap4;

class Build extends \Argo\Infra\Build
{
    public function theme() : void
    {
        parent::theme();
        $this->write("/theme/style.css", "theme/style.css");
    }
}
