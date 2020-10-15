<?php
declare(strict_types=1);

namespace Argo\Domain;

use DateTimeImmutable;
use DateTimeZone;

class DateTime
{
    protected $timezone = 'UTC';

    public function setTimezone(string $timezone) : void
    {
        $this->timezone = $timezone;
    }

    public function getTimezone() : string
    {
        return $this->timezone;
    }

    public function local(string $utcTime, string $format) : string
    {
        $date = new DateTimeImmutable($utcTime);
        $date = $date->setTimezone(new DateTimeZone($this->timezone));
        return $date->format($format);
    }

    public function utc() : string
    {
        $date = new DateTimeImmutable($this->now(), new DateTimeZone('UTC'));
        return $date->format('Y-m-d H:i:s e');
    }

    public function month(string $ym) : string
    {
        return $this->local("{$ym}-01 12:00:00", 'F Y');
    }

    public function ymd() : string
    {
        return $this->local($this->utc(), 'Y/m/d');
    }

    protected function now() : string
    {
        return 'now';
    }
}
