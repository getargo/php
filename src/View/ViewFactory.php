<?php
declare(strict_types=1);

namespace Argo\View;

use Argo\Domain\Config\Config;
use Argo\Domain\Storage;
use Argo\Domain\DateTime as DateTimeFormat;
use Aura\Html\HelperLocatorFactory;
use Aura\View\TemplateRegistry;
use Aura\View\View;
use AutoRoute\Generator;
use Capsule\Di\Container;
use League\CommonMark\CommonMarkConverter;

class ViewFactory
{
    protected $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * @var array $dirs These need to be absolute, not relative, directories.
     */
    public function new(array $dirs) : View
    {
        $helpersFactory = new HelperLocatorFactory();

        $helpers = $helpersFactory->newInstance();

        $helpers->set('anchorLocal', function () use ($helpers) {
            return new Helper\AnchorLocal(
                $helpers->get('escape'),
                $helpers->get('anchor')
            );
        });

        $helpers->set('anchorOpenFolder', function () use ($helpers) {
            return new Helper\AnchorOpenFolder(
                $helpers->get('escape'),
                $helpers->get('anchor')
            );
        });

        $helpers->set('body', function () {
            return new Helper\Body(
                $this->container->get(Storage::CLASS)
            );
        });

        $helpers->set('dateTime', function () use ($helpers) {
            return new Helper\DateTime(
                $helpers->get('escape'),
                $this->container->get(DateTimeFormat::CLASS)
            );
        });

        $helpers->set('route', function () {
            return new Helper\Route(
                $this->container->get(Generator::CLASS)
            );
        });

        $helpers->set('routeSubmit', function () use ($helpers) {
            return new Helper\RouteSubmit(
                $helpers->get('route'),
                $helpers->get('input')
            );
        });

        return new View(
            new TemplateRegistry([], $dirs),
            new TemplateRegistry([], $dirs),
            $helpers
        );
    }
}
