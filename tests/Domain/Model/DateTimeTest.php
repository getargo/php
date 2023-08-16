<?php
declare(strict_types=1);

namespace Argo\Domain\Model;

class DateTimeTest extends \Argo\Domain\TestCase
{
    protected $dateTime;

    protected function setUp() : void
    {
        $this->dateTime = new DateTime();
    }

    public function testTimezone() : void
    {
        $this->assertSame('UTC', $this->dateTime->getTimezone());
        $this->dateTime->setTimezone('America/Chicago');
        $this->assertSame('America/Chicago', $this->dateTime->getTimezone());
    }

    public function testUtc() : void
    {
        $utc = $this->dateTime->utc();
        $this->assertRegexp('/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2} UTC$/', $utc);
    }
}
