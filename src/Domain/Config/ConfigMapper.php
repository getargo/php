<?php
declare(strict_types=1);

namespace Argo\Domain\Config;

use Argo\Domain\Json;
use Argo\Domain\Storage;

class ConfigMapper
{
    protected $storage;

    protected $identityMap = [];

    public function __construct(Storage $storage)
    {
        $this->storage = $storage;
    }

    public function __get(string $name)
    {
        $id = "_argo/{$name}";

        if (! isset($this->identityMap[$id])) {
            $data = $this->read($id);
            $this->identityMap[$id] = $this->new($id, $data);
        }

        return $this->identityMap[$id];
    }

    public function __isset(string $name)
    {
        $id = "_argo/{$name}";

        $storageId = ($id === '_argo/theme')
            ? "_argo/theme/{$this->general->theme}"
            : $id;

        return isset($this->identityMap[$id])
            || $this->storage->exists("{$storageId}.json");
    }

    protected function read(string $id) : object
    {
        if ($id === '_argo/theme') {
            $id = "_argo/theme/{$this->general->theme}";
        }

        $text = $this->storage->read("{$id}.json");
        return Json::decode($text);
    }

    public function new(string $id, object $data) : Config
    {
        return new Config($id, $data);
    }

    public function save(Config $values) : void
    {
        $id = $values->getId();
        $storageId = ($id === '_argo/theme')
            ? "_argo/theme/{$this->general->theme}"
            : $id;
        $data = $values->getData();
        $text = Json::encode($data);
        $this->storage->write("{$storageId}.json", $text);
        $this->identityMap[$id] = $values;
    }
}
