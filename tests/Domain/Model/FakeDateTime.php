<?php
declare(strict_types=1);

namespace Argo\Domain\Model;

use DateTimeImmutable;
use DateTimeZone;

class FakeDateTime extends DateTime
{
    public $now = 'now';

    protected function now() : string
    {
        return $this->now;
    }

    public function modify(string $modifier) : string
    {
        $date = new DateTimeImmutable($this->now(), new DateTimeZone('UTC'));
        $date = $date->modify($modifier);
        $this->now = $date->format('Y-m-d H:i:s e');
        return $this->now;
    }
}
