<?php
declare(strict_types=1);

namespace Argo\Infra;

use Argo\Infra\Log;
use Argo\Domain\Model\Config\ConfigMapper;
use Argo\Domain\Model\Content\ContentLocator;
use Argo\Domain\Model\Content\Folio;
use Argo\Domain\Model\Content\Month;
use Argo\Domain\Model\DateTime;
use Argo\Domain\Storage;
use Argo\Infra\Template\Helper;
use Capsule\Di\Container;
use Qiq\Template;

class BuildFactory
{
    protected $container;

    protected $dateTime;

    protected $storage;

    protected $config;

    protected $content;

    protected $log;

    protected $view;

    public function __construct(
        Container $container,
        DateTime $dateTime,
        Storage $storage,
        ConfigMapper $config,
        ContentLocator $content,
        Log $log,
    ) {
        $this->container = $container;
        $this->dateTime = $dateTime;
        $this->storage = $storage;
        $this->config = $config;
        $this->content = $content;
        $this->log = $log;
    }

    public function new(string $level = 'info') : Build
    {
        // foo/bar-baz => Foo\BarBaz\Build
        $class = $this->config->general->theme;
        $class = ucwords($class, '-/');
        $class = str_replace('-', '', $class);
        $class = str_replace('/', '\\', $class) . '\Build';

        return new $class(
            $this->storage,
            $this->config,
            $this->log,
            $level,
            $this->newTemplate(),
            Folio::new($this->storage, $this->config, $this->content, $this->dateTime)
        );
    }

    protected function newTemplate() : Template
    {
        $tpl = Template::new();
        $helpers = $tpl->getHelperLocator();
        $helpers->set('body', $this->container->callableNew(Helper\Body::CLASS));
        $helpers->set('bodyLess', $this->container->callableNew(Helper\BodyLess::CLASS));
        $helpers->set('penders', $this->container->callableNew(Helper\Penders::CLASS));
        $helpers->set('dateTime', $this->container->callableNew(Helper\DateTime::CLASS));
        return $tpl;
    }
}
