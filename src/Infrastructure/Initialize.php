<?php
declare(strict_types=1);

namespace Argo\Infrastructure;

use Argo\Domain\Config\Config;
use Argo\Domain\Content\ContentLocator;
use Argo\Domain\Content\Post\Post;
use Argo\Domain\DateTime;
use Argo\Domain\Storage;
use Argo\Infrastructure\BuildFactory;

class Initialize
{
    public function __construct(
        DateTime $dateTime,
        Config $config,
        ContentLocator $content,
        Storage $storage,
        BuildFactory $buildFactory
    ) {
        $this->dateTime = $dateTime;
        $this->config = $config;
        $this->content = $content;
        $this->storage = $storage;
        $this->buildFactory = $buildFactory;
    }

    public function __invoke()
    {
        $text = [
            'Header set Cache-Control "no-cache, no-store, must-revalidate, max-age=0"',
            'Header set Expires "0"',
            'Header set Pragma "no-cache"',
        ];

        $this->storage->write('.htaccess', implode("\n", $text));

        $date = $this->dateTime->ymd();
        $relId = "{$date}/sample-post";
        $post = new Post(
            Post::absId($relId),
            [
                'title' => 'Sample Post',
                'author' => $this->config->general->author,
                'tags' => ['general'],
            ]
        );
        $this->content->posts->save($post, 'Sample post body.');
        $this->buildFactory->new()->all();
    }
}
