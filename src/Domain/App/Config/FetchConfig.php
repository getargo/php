<?php
declare(strict_types=1);

namespace Argo\Domain\App\Config;

use Argo\Domain\Model\Config\ConfigMapper;
use Argo\Domain\Json;
use Argo\Domain\Payload;
use Argo\Domain\App;

class FetchConfig extends App
{
    protected $config;

    public function __construct(ConfigMapper $config)
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
