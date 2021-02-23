<?php
declare(strict_types=1);

namespace Argo;

use Argo\Domain\Config\ConfigMapper;
use Argo\Domain\Content\ContentLocator;
use Argo\Domain\DateTime;
use Argo\Domain\Json;
use Argo\Domain\Storage;
use Argo\Infra\System;

abstract class TestCase extends \PHPUnit\Framework\TestCase
{
    protected $container;

    protected $storage;

    protected $config;

    protected $content;

    protected $stdout;

    protected $stderr;

    protected $system;

    protected function setUp() : void
    {
        $tmp = __DIR__ . '/tmp';
        exec("rm -rf $tmp/*");
        exec("rm -rf $tmp/.config");

        $this->stdout = fopen('php://memory', 'w+');
        $this->stderr = fopen('php://memory', 'w+');

        $this->container = TestContainerFactory::new();
        $this->dateTime = $this->container->get(DateTime::CLASS);
        $this->storage = $this->container->get(Storage::CLASS);
        $this->content = $this->container->get(ContentLocator::CLASS);
        $this->config = $this->container->get(ConfigMapper::CLASS);
        $this->system = $this->container->get(System::CLASS);

        $this->setDateTimeNow('0001-02-03 12:34:56');
    }

    protected function assertJsonEquals(
        /* array|object */ $expect,
        string $actual
    ) : void
    {
        $this->assertEquals(trim(Json::encode($expect)), trim($actual));
    }

    protected function varExport($var) : void
    {
        $str = var_export($var, true);
        $str = preg_replace('/=> *\n* */m', '=> ', $str);
        $str = preg_replace('/array *\(+/m', '[', $str);
        $str = preg_replace('/^( *)\)(.*)/m', '$1]$2', $str);
        $str = preg_replace('/^(  )( *) (\'.*)/m', '$1$2$3', $str);
        $str = preg_replace('/( +)(.*)/m', '$1$1$2', $str);
        $str = preg_replace_callback(
            '/(TRUE|FALSE|NULL),$/m',
            function ($matches) { return strtolower($matches[0]); },
            $str
        );
        echo "\n\n$str\n\n";
    }

    protected function setDateTimeNow(string $now) : string
    {
        $this->dateTime->now = $now;
        return $now;
    }

    protected function modDateTimeNow(string $modifier) : string
    {
        return $this->dateTime->modify($modifier);
    }
}
