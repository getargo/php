<?php
declare(strict_types=1);

namespace Argo\Domain\Config;

use Argo\Domain\Json;
use Argo\Domain\Storage;

class ConfigGateway
{
    protected $storage;

    public function __construct(Storage $storage)
    {
        $this->storage = $storage;
    }

    public function getConfig() : Config
    {
        $instances = [];
        $files = $this->storage->glob('_argo/*.json');

        foreach ($files as $file) {
            $file = basename($file);
            $name = substr($file, 0, strpos(basename($file), '.'));
            $id = "_argo/{$name}";
            $text = $this->storage->read("{$id}.json");
            $data = Json::decode($text);
            $instances[$name] = $this->newValues($id, $data);
        }

        if (isset($instances['general']->theme)) {
            $theme = $instances['general']->theme ?? 'argo/original';
            $id = "_argo/theme/{$theme}";
            $text = $this->storage->read("{$id}.json") ?? '{}';
            $data = Json::decode($text);
            $instances['theme'] = $this->newValues($id, $data);
        }

        return $this->newConfig($instances);
    }

    protected function newConfig(array $instances) : Config
    {
        return new Config($instances);
    }

    public function newValues(string $id, object $data) : Values
    {
        return new Values($id, $data);
    }

    public function saveValues(Values $values) : void
    {
        $id = $values->getId();
        $data = $values->getData();
        $text = Json::encode($data);
        $this->storage->write("{$id}.json", $text);
    }
}
