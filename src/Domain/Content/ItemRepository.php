<?php
declare(strict_types=1);

namespace Argo\Domain\Content;

use Argo\Domain\Config\ConfigMapper;
use Argo\Domain\Content\ContentLocator;
use Argo\Domain\DateTime;
use Argo\Domain\Exception;
use Argo\Domain\Json;
use Argo\Domain\Repository;
use Argo\Domain\Storage;

abstract class ItemRepository
{
    protected $config;

    protected $content;

    protected $dateTime;

    protected $storage;

    protected $type;

    public function __construct(
        DateTime $dateTime,
        Storage $storage,
        ConfigMapper $config,
        ContentLocator $content
    ) {
        $this->dateTime = $dateTime;
        $this->storage = $storage;
        $this->config = $config;
        $this->content = $content;
        $this->type = substr(static::CLASS, 0, -10);
    }

    abstract protected function getGlob() : string;

    public function save(Item $item, ?string $body) : void
    {
        $this->assertType($item);
        $utcTime = $this->dateTime->utc();

        if ($item->data->created === null) {
            $item->data->created = $utcTime;
        }

        $item->data->updated[] = $utcTime;
        $this->storage->write("{$item->id}/argo.json", $item->getText());

        if ($body !== null) {
            $this->storage->write($item->getBodyFile(), $body);
        }
    }

    public function getItem(string $relId) : ?Item
    {
        $id = ($this->type)::absId($relId);
        $text = $this->read($id, 'argo.json');
        if ($text === null) {
            return null;
        }

        $data = Json::decode($text, true);
        $class = $this->type;
        return new $class($id, $data);
    }

    public function getBody(Item $item) : ?string
    {
        $file = "argo.{$item->markup}";
        return $this->read($item->id, $file);
    }

    public function listCounts() : array
    {
        $perPage = $this->config->general->perPage;
        $items = $this->storage->glob($this->getGlob());
        $itemCount = count($items);
        $pageCount = (int) ceil($itemCount / $perPage);
        return [$itemCount, $pageCount];
    }

    public function getItems(?int $pageNum = null) : array
    {
        $perPage = $this->config->general->perPage;

        if ($pageNum === null) {
            $first = null;
            $last = null;
        } else {
            $first = ($pageNum - 1) * $perPage;
            $last = ($first + $perPage) - 1;
        }

        $class = $this->type;
        $items = [];

        $prev = null;
        foreach ($this->glob() as $i => $file) {
            if ($first !== null && $i < $first) {
                continue;
            }

            if ($last !== null && $i > $last) {
                break;
            }

            $id = $this->getIdFromFile($file);
            $text = $this->read($id, 'argo.json');
            $data = Json::decode($text, true);
            $item = new $class($id, $data);
            $item->setPrev($prev);

            if ($prev !== null) {
                $prev->setNext($item);
            }

            $items[$id] = $item;
            $prev = $item;
        }

        return $items;
    }

    public function trash(Item $item) : void
    {
        $this->assertType($item);
        $this->storage->trash($item->id);
    }

    protected function assertType(Item $item) : void
    {
        if (! $item instanceof $this->type) {
            throw new Exception("Wrong type: " . get_class($item));
        }
    }

    protected function getIdFromFile(string $file) : string
    {
        $root = $this->storage->path('/');
        return substr($file, strlen($root));
    }

    protected function glob() : array
    {
        return $this->storage->glob($this->getGlob());
    }

    protected function read(string $id, string $file) : ?string
    {
        try {
            ($this->type)::assertId($id);
        } catch (Exception\InvalidData $e) {
            return null;
        }

        return $this->storage->read("{$id}/{$file}");
    }
}
