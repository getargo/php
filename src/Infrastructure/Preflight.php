<?php
declare(strict_types=1);

namespace Argo\Infrastructure;

use Argo\Domain\Config\Config;
use Argo\Domain\Config\ConfigGateway;
use Argo\Domain\DateTime;
use Argo\Domain\Json;
use Argo\Domain\Storage;
use RuntimeException;

class Preflight
{
    protected $system;

    protected $dateTime;

    protected $storage;

    protected $config;

    protected $configGateway;

    protected $initialize;

    protected $server;

    public function __construct(
        System $system,
        DateTime $dateTime,
        Storage $storage,
        Config $config,
        ConfigGateway $configGateway,
        Initialize $initialize,
        Server $server
    ) {
        $this->system = $system;
        $this->dateTime = $dateTime;
        $this->storage = $storage;
        $this->config = $config;
        $this->configGateway = $configGateway;
        $this->initialize = $initialize;
        $this->server = $server;
    }

    public function __invoke(string $path) : ?string
    {
        $this->extensions();

        $sites = $this->system->sites();
        if (empty($sites)) {
            if (trim($path, '/') === 'setup') {
                return null;
            }

            return '/setup/';
        }

        $docroot = $this->system->docroot();

        if ($docroot === '' || ! is_dir($docroot)) {
            $docroot = reset($sites);
            $this->server->stop($docroot);
            return '/';
        }

        $this->storage->forceDir('_trash');
        $this->storage->forceDir('_theme');

        $this->configs();
        $this->dateTime->setTimezone($this->config->general->timezone);

        if ($this->config->admin->initialize ?? false) {
            ($this->initialize)();
            unset($this->config->admin->initialize);
            $this->configGateway->saveValues($this->config->admin);
        }

        $this->server->start();

        return null;
    }

    protected function extensions() : void
    {
        $missing = ['date', 'dom', 'json'];

        foreach ($missing as $key => $val) {
            if (extension_loaded($val)) {
                unset($missing[$key]);
            }
        }

        if ($missing) {
            $message = "Please install the following PHP extensions: "
                . implode(', ', $missing);
            throw new RuntimeException($message);
        }
    }

    protected function configs() : void
    {
        $this->config('admin', [
            'lastBuild' => null,
            'lastSync' => null,
            'version' => null,
        ]);

        $this->config('blogroll', []);

        $this->config('featured', []);

        $this->config('general', [
            'title' => '',
            'tagline' => '',
            'author' => '',
            'url' => '',
            'timezone' => $this->system->timezone(),
            'perPage' => 10,
        ]);

        $this->config('menu', []);

        $this->config('sync', [
            'type' => 'git',
            'host' => '',
            'user' => '',
            'path' => '',
        ]);

        $this->config('theme', [
            'name' => 'default',
        ]);
    }

    protected function config($name, array $default) : void
    {
        $old = isset($this->config->$name)
            ? $this->config->$name->getData()
            : null;

        if ($old === null) {
            // no existing config, create from default
            $this->config->$name = $this->configGateway->newValues(
                $name,
                Json::recode($default)
            );
            $this->configGateway->saveValues($this->config->$name);
            return;
        }

        $old = Json::recode($old, true);
        $new = array_replace($default, $old);
        if ($new !== $old) {
            // pre-existing config, write the changed values
            $this->config->$name->setData(Json::recode((object) $new));
            $this->configGateway->saveValues($this->config->$name);
        }
    }
}
