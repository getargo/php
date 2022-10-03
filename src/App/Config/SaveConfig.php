<?php
declare(strict_types=1);

namespace Argo\App\Config;

use Argo\Domain\Model\Config\ConfigMapper;
use Argo\Domain\Json;
use Argo\Infra\BuildFactory;
use Argo\App\Payload;
use Argo\App\App;

class SaveConfig extends App
{
    protected $config;

    protected $buildFactory;

    public function __construct(
        ConfigMapper $config,
        BuildFactory $buildFactory
    ) {
        $this->config = $config;
        $this->buildFactory = $buildFactory;
    }

    protected function exec(string $name, string $text) : Payload
    {
        if (! isset($this->config->$name)) {
            return Payload::notFound();
        }

        $text = trim($text);

        if ($text === '') {
            return Payload::invalid(['invalid' => 'The config cannot be blank.']);
        }

        $data = Json::decode($text);
        $this->config->$name->setData($data);
        $this->config->save($this->config->$name);

        switch ($name) {
            case 'menu':
                $this->buildFactory->new()->menuShtml();
                break;
            case 'blogroll':
                $this->buildFactory->new()->blogrollShtml();
                break;
            case 'theme':
                $this->buildFactory->new()->theme();
                break;
            default:
                // @todo: $this->config->admin->needsBuild = true;
                break;
        }

        return Payload::updated([
            'item' => (object) [
                'type' => 'config',
                'relId' => $name,
            ]
        ]);
    }
}
