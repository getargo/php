<?php
declare(strict_types=1);

namespace Argo\Infra;

use Argo\Domain\Config\Config;
use Argo\Domain\Config\ConfigGateway;
use Argo\Domain\Content\ContentLocator;
use Argo\Domain\Content\Folio;
use Argo\Domain\Content\Month;
use Argo\Domain\DateTime;
use Argo\Domain\Log;
use Argo\Domain\Storage;
use Argo\View\ViewFactory;

class BuildFactory
{
    protected $dateTime;

    protected $storage;

    protected $config;

    protected $content;

    protected $log;

    protected $view;

    protected $viewFactory;

    public function __construct(
        DateTime $dateTime,
        Storage $storage,
        Config $config,
        ConfigGateway $configGateway,
        ContentLocator $content,
        Log $log,
        ViewFactory $viewFactory
    ) {
        $this->dateTime = $dateTime;
        $this->storage = $storage;
        $this->config = $config;
        $this->configGateway = $configGateway;
        $this->content = $content;
        $this->log = $log;
        $this->viewFactory = $viewFactory;
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
            $this->configGateway,
            $this->log,
            $level,
            $this->viewFactory,
            Folio::new($this->storage, $this->config, $this->content, $this->dateTime)
        );
    }
}
