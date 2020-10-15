<?php
declare(strict_types=1);

namespace Argo\Domain\Config;

use Argo\Domain\Json;
use Argo\Domain\Storage;
use Argo\Domain\Config\Values\Values;

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
            $text = $this->storage->read("_argo/{$name}.json");
            $data = Json::decode($text);
            $instances[$name] = $this->newValues($name, $data);
        }

        return $this->newConfig($instances);
    }

    protected function newConfig(array $instances) : Config
    {
        return new Config($instances);
    }

    public function newValues(string $name, object $data) : Values
    {
        $class = 'Argo\Domain\Config\Values\\' . ucfirst($name);
        return new $class($data);
    }

    public function saveValues(Values $values) : void
    {
        $name = strtolower(substr(strrchr(get_class($values), '\\'), 1));
        $data = $values->getData();
        $text = Json::encode($data);
        $this->storage->write("_argo/{$name}.json", $text);
    }
}
