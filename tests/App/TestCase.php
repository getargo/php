<?php
declare(strict_types=1);

namespace Argo\App;

use Argo\Domain\FakeDateTime;
use Argo\Domain\Json;
use Argo\Infra\BuildFactory;
use Argo\Infra\Preflight;
use Argo\Infra\System;

abstract class TestCase extends \Argo\TestCase
{
    protected function setUp() : void
    {
        parent::setUp();
        $this->dateTime->setTimezone('UTC');
    }

    protected function setUpArgo() : void
    {
        /* fake a previous AddSite interaction */
        $docroot = $this->system->docroot();

        mkdir("{$docroot}/_argo", 0755, true);

        $this->config->general = $this->configGateway->newValues('_argo/general', (object) [
            'title' => 'Argo Blog Title',
            'tagline' => 'Argo Blog Tagline',
            'author' => 'boshag',
            'url' => 'http://example.com',
            'theme' => 'bootstrap4'
        ]);

        $this->configGateway->saveValues($this->config->general);

        $this->config->admin = $this->configGateway->newValues('_argo/admin', (object) [
            'initialize' => true,
        ]);

        $this->configGateway->saveValues($this->config->admin);

        file_put_contents(
            $this->system->supportDir() . '/docroot.php',
            "<?php return '{$docroot}';"
        );

        /* preflight will create the needed structure */
        $preflight = $this->container->get(Preflight::CLASS);
        $preflight('/');
    }

    protected function invoke(...$args) : Payload
    {
        $class = substr(get_class($this), 0, -4);
        $useCase = $this->container->get($class);
        $payload = $useCase(...$args);
        return $payload;
    }

    protected function assertCreated(Payload $actual) : void
    {
        $this->assertStatus(Status::CREATED, $actual);
    }

    protected function assertUpdated(Payload $actual) : void
    {
        $this->assertStatus(Status::UPDATED, $actual);
    }

    protected function assertDeleted(Payload $actual) : void
    {
        $this->assertStatus(Status::DELETED, $actual);
    }

    protected function assertNotFound(Payload $actual) : void
    {
        $this->assertStatus(Status::NOT_FOUND, $actual);
    }

    protected function assertFound(Payload $actual) : void
    {
        $this->assertStatus(Status::FOUND, $actual);
    }

    protected function assertInvalid(Payload $actual, string $message = null) : void
    {
        $this->assertStatus(Status::INVALID, $actual);
        if ($message !== null) {
            $this->assertStringContainsString($message, $actual->getResult()['invalid']);
        }
    }

    protected function assertError(Payload $actual, string $message = null) : void
    {
        $this->assertStatus(Status::ERROR, $actual);
        if ($message !== null) {
            $this->assertStringContainsString($message, $actual->getResult()['error']);
        }
    }

    protected function assertProcessing(Payload $actual) : void
    {
        $this->assertStatus(Status::PROCESSING, $actual);
    }

    protected function assertAccepted(Payload $actual) : void
    {
        $this->assertStatus(Status::ACCEPTED, $actual);
    }

    protected function assertSuccess(Payload $actual) : void
    {
        $this->assertStatus(Status::SUCCESS, $actual);
    }

    protected function assertStatus($expect, Payload $actual)
    {
        $this->assertSame(
            $expect,
            $actual->getStatus(),
            "Expected {$expect}, got " .  print_r($actual, true)
        );
    }
}
