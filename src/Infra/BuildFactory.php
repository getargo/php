<?php
declare(strict_types=1);

namespace Argo\Infra;

use Argo\Domain\Model\Config\ConfigMapper;
use Argo\Domain\Model\Content\ContentLocator;
use Argo\Domain\Model\Content\Folio;
use Argo\Domain\Model\Content\Month;
use Argo\Domain\Model\DateTime;
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
        ConfigMapper $config,
        ContentLocator $content,
        Log $log,
        ViewFactory $viewFactory
    ) {
        $this->dateTime = $dateTime;
        $this->storage = $storage;
        $this->config = $config;
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
            $this->log,
            $level,
            $this->viewFactory,
            Folio::new($this->storage, $this->config, $this->content, $this->dateTime)
        );
    }
}
