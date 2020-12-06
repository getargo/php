<?php
declare(strict_types=1);

namespace Argo\UseCase\Site;

use Argo\Domain\Content\Post\Post;
use Argo\Domain\DateTime;
use Argo\Domain\Json;
use Argo\Infrastructure\Server;
use Argo\Infrastructure\System;
use Argo\UseCase\Payload;
use Argo\UseCase\UseCase;

class AddSite extends UseCase
{
    protected $system;

    protected $dateTime;

    protected $server;

    protected $general = [];

    protected $docroot;

    public function __construct(
        System $system,
        DateTime $dateTime,
        Server $server
    ) {
        $this->system = $system;
        $this->server = $server;
        $this->dateTime = $dateTime;
    }

    protected function exec(array $input = null) : Payload
    {
        return $this->default($input)
            ?? $this->validate($input)
            ?? $this->create();
    }

    protected function default(?array $input) : ?Payload
    {
        if ($input === null) {
            return Payload::found([
                'name' => '',
                'title' => '',
                'tagline' => '',
                'author' => $this->system->whoami(),
                'url' => '',
            ]);
        }

        return null;
    }

    protected function validate(array $input) : ?Payload
    {
        $name = strtolower(trim($input['name'] ?? ''));

        if ($name === '') {
            return Payload::invalid([
                'invalid' => 'The folder name may not be blank.'
            ]);
        }

        if (! preg_match('/^[a-z0-9-]+$/', $name)) {
            return Payload::invalid([
                'invalid' => "The folder name may use only a-z, 0-9, and dashes.",
            ]);
        }

        $docroot = $this->system->sitesDir() . "/{$name}";

        if (is_dir($docroot)) {
            return Payload::invalid([
                'invalid' => "A folder with the name '$name' already exists."
            ]);
        }

        $title = trim($input['title'] ?? '');

        if ($title === '') {
            return Payload::invalid([
                'invalid' => 'The blog title may not be blank.'
            ]);
        }

        $tagline = trim($input['tagline'] ?? '');
        $author = trim($input['author'] ?? '');

        if ($author === '') {
            return Payload::invalid([
                'invalid' => 'The author username may not be blank.',
            ]);
        }

        if (! preg_match('/^[a-z0-9-]+$/', $author)) {
            return Payload::invalid([
                'invalid' => 'The author username may use only a-z, 0-9, and dashes.',
            ]);
        }

        $url = trim($input['url'] ?? '');

        if ($url === '') {
            return Payload::invalid([
                'invalid' => 'The blog URL may not be blank.',
            ]);
        }

        $parts = parse_url($url);

        if ($parts === false || empty($parts['host'])) {
            return Payload::invalid([
                'invalid' => 'The blog URL does not look right.',
            ]);
        }

        $this->docroot = $docroot;
        $this->general = [
            'title' => $title,
            'tagline' => $tagline,
            'author' => $author,
            'url' => $url,
        ];

        return null;
    }

    protected function create() : Payload
    {
        mkdir("{$this->docroot}/_argo", 0755, true);

        file_put_contents(
            "{$this->docroot}/_argo/general.json",
            Json::encode($this->general)
        );

        file_put_contents(
            "{$this->docroot}/_argo/theme.json",
            Json::encode([
                'name' => 'default',
                'sidebar' => [
                    'search',
                    'months',
                    'tags',
                ],
                'style' => [
                    "sans_serif_fonts" => "-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, 'Noto Sans', sans-serif",
                    "serif_fonts" => "Georgia, 'Times New Roman', Times, serif",
                    "monospace_fonts" => "SFMono-Regular, Menlo, Monaco, Consolas, 'Liberation Mono', 'Courier New', monospace",
                    "link_color" => "#438287",
                    "link_color_hover" => "#205d5f",
                    "header_font_color" => "black",
                    "header_background_color" => "#f7f7f7",
                    "header_background_image" => "url('/theme/default/beach-sky.jpg')",
                    "footer_font_color" => "black",
                    "footer_background_color" => "#f7f7f7"
                ],
            ])
        );

        file_put_contents("{$this->docroot}/_argo/admin.json", Json::encode([
            'initialize' => true,
        ]));

        $this->server->stop($this->docroot);

        return Payload::success();
    }
}
