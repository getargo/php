<?php
declare(strict_types=1);

namespace Argo\Infrastructure;

use Argo\Domain\DateTime;
use Argo\Domain\Config\Config;
use Argo\Domain\Content\ContentLocator;
use Argo\Domain\Content\Post\Post;
use Argo\Infrastructure\BuildFactory;

class Initialize
{
    public function __construct(
        DateTime $dateTime,
        Config $config,
        ContentLocator $content,
        BuildFactory $buildFactory
    ) {
        $this->dateTime = $dateTime;
        $this->config = $config;
        $this->content = $content;
        $this->buildFactory = $buildFactory;
    }

    public function __invoke()
    {
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
