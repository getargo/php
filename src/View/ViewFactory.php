<?php
declare(strict_types=1);

namespace Argo\View;

use Argo\Domain\Storage;
use Argo\Domain\DateTime as DateTimeFormat;
use AutoRoute\Generator;
use Capsule\Di\Container;
use League\CommonMark\CommonMarkConverter;
use Qiq\Template;

class ViewFactory
{
    protected $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function new(array $paths) : Template
    {
        $tpl = $this->container->new(Template::CLASS);
        $tpl->getTemplateLocator()->setPaths($paths);
        return $tpl;
    }
}
