<?php
declare(strict_types=1);

namespace Argo\UseCase\Config;

use Argo\Domain\Config\Config;
use Argo\Domain\Config\ConfigGateway;
use Argo\Domain\Json;
use Argo\Infrastructure\BuildFactory;
use Argo\UseCase\Payload;
use Argo\UseCase\UseCase;

class SaveConfig extends UseCase
{
    protected $config;

    protected $configGateway;

    protected $buildFactory;

    public function __construct(
        Config $config,
        ConfigGateway $configGateway,
        BuildFactory $buildFactory
    ) {
        $this->config = $config;
        $this->configGateway = $configGateway;
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
        $this->configGateway->saveValues($this->config->$name);

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
