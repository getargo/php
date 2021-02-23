<?php
declare(strict_types=1);

namespace Argo\Domain\Config;

use Argo\Domain\Json;
use ArrayIterator;
use IteratorAggregate;

class Config implements IteratorAggregate
{
    protected $id;

    protected $data;

    public function __construct(string $id, object $data = null)
    {
        $this->id = $id;
        $this->data = (object) [];

        if ($data !== null) {
            $this->setData($data);
        }
    }

    public function __get($key)
    {
        return $this->data->$key;
    }

    public function __set($key, $val)
    {
        $this->data->$key = $val;
    }

    public function __isset($key)
    {
        return isset($this->data->$key);
    }

    public function __unset($key)
    {
        unset($this->data->$key);
    }

    public function getText() : string
    {
        return Json::encode($this->data);
    }

    public function setData(object $data) : void
    {
        $this->data = $data;
    }

    public function getData() : object
    {
        return $this->data;
    }

    public function getIterator()
    {
        return new ArrayIterator($this->data);
    }

    public function getId() : string
    {
        return $this->id;
    }
}
