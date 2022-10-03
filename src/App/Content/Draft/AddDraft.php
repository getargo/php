<?php
declare(strict_types=1);

namespace Argo\App\Content\Draft;

use Argo\Domain\Model\Config\ConfigMapper;
use Argo\Domain\Model\Content\ContentLocator;
use Argo\Domain\Model\Content\Draft\Draft;
use Argo\Domain\Model\DateTime;
use Argo\Domain\Json;
use Argo\App\Payload;
use Argo\App\App;

class AddDraft extends App
{
    protected $dateTime;

    protected $config;

    protected $content;

    public function __construct(
        DateTime $dateTime,
        ConfigMapper $config,
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
