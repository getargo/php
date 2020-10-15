<?php
declare(strict_types=1);

namespace Argo\UseCase\Content\Draft;

use Argo\Domain\Config\Config;
use Argo\Domain\Content\ContentLocator;
use Argo\Domain\Content\Draft\Draft;
use Argo\Domain\DateTime;
use Argo\Domain\Json;
use Argo\UseCase\Payload;
use Argo\UseCase\UseCase;

class AddDraft extends UseCase
{
    protected $dateTime;

    protected $config;

    protected $content;

    public function __construct(
        DateTime $dateTime,
        Config $config,
        ContentLocator $content
    ) {
        $this->dateTime = $dateTime;
        $this->config = $config;
        $this->content = $content;
    }

    protected function exec(string $title) : Payload
    {
        $title = trim($title);
        if ($title === '') {
            $title = 'Untitled';
        }

        $utcTime = $this->dateTime->utc();

        $data = [
            'title' => $title,
            'author' => $this->config->general->author,
            'tags' => [
                'general',
            ],
        ];

        $relId = $this->dateTime->local($utcTime, 'Ymd\THis');

        $draft = new Draft(
            Draft::absId($relId),
            $data
        );

        $this->content->drafts->save($draft, '');

        return Payload::created(['item' => $draft]);
    }
}
