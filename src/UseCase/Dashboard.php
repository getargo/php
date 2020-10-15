<?php
declare(strict_types=1);

namespace Argo\UseCase;

use Argo\Domain\Config\Config;
use Argo\Domain\Content\ContentLocator;
use Argo\Domain\Storage;
use Argo\UseCase\Payload;
use Argo\UseCase\UseCase;

class Dashboard extends UseCase
{
    protected $system;

    protected $config;

    protected $content;

    public function __construct(
        Storage $storage,
        Config $config,
        ContentLocator $content
    ) {
        $this->storage = $storage;
        $this->config = $config;
        $this->content = $content;
    }

    protected function exec() : Payload
    {
        return Payload::found([
            'drafts' => $this->content->drafts->getItems(),
            'posts' => $this->content->posts->getItems(1, $this->config->general->perPage),
            'remote' => trim((string) $this->config->general->url),
            'local' => $this->storage->path(),
        ]);
    }
}
