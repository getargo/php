<?php
declare(strict_types=1);

namespace Argo\App;

use Argo\Domain\Config\ConfigMapper;
use Argo\Domain\Content\ContentLocator;
use Argo\Domain\Storage;
use Argo\App\Payload;
use Argo\App\UseCase;

class Dashboard extends UseCase
{
    protected $system;

    protected $config;

    protected $content;

    public function __construct(
        Storage $storage,
        ConfigMapper $config,
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
        ]);
    }
}
