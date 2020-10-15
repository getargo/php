<?php
declare(strict_types=1);

namespace Argo\UseCase\Config;

use Argo\Domain\Config\Config;
use Argo\Domain\Json;
use Argo\UseCase\Payload;
use Argo\UseCase\UseCase;

class FetchConfig extends UseCase
{
    protected $config;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    protected function exec(string $name) : Payload
    {
        $text = isset($this->config->$name)
            ? $this->config->$name->getText()
            : null;

        if ($text === null) {
            return Payload::notFound();
        }

        return Payload::found([
            'name' => $name,
            'text' => $text . PHP_EOL,
        ]);
    }
}
