<?php
declare(strict_types=1);

namespace Argo\Domain\Config;

use Argo\Domain\Config\Values\Values;
use Argo\Domain\Exception;

class Config
{
    protected $instances = [];

    public function __construct(array $instances)
    {
        foreach ($instances as $key => $val) {
            $this->$key = $val;
        }
    }

    public function __get($key)
    {
        return $this->instances[$key];
    }

    public function __set($key, $val)
    {
        $this->assertValues($val);
        $this->instances[$key] = $val;
    }

    public function __isset($key)
    {
        return isset($this->instances[$key]);
    }

    public function __unset($key)
    {
        unset($this->instances[$key]);
    }

    protected function assertValues($val) : void
    {
        if (! $val instanceof Values) {
            throw new Exception('Not an instance of ' . Values::CLASS);
        }
    }
}
