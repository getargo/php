<?php
declare(strict_types=1);

namespace Argo\Infra;

use Argo\Domain\Model\Content\ContentLocator;
use Argo\Domain\Model\Content\Post\Post;
use Argo\Domain\Model\Config\ConfigMapper;
use Argo\Domain\Model\DateTime;
use Argo\Domain\Json;
use Argo\Infra\Log;
use Argo\Domain\Storage;
use RuntimeException;

class Preflight
{
    protected $system;

    protected $dateTime;

    protected $storage;

    protected $config;

    protected $initialize;

    protected $server;

    public function __construct(
        System $system,
        DateTime $dateTime,
        Storage $storage,
        ConfigMapper $config,
        Initialize $initialize,
        Server $server,
        ContentLocator $content,
        BuildFactory $buildFactory
    ) {
        $this->system = $system;
        $this->dateTime = $dateTime;
        $this->storage = $storage;
        $this->config = $config;
        $this->initialize = $initialize;
        $this->server = $server;
        $this->content = $content;
        $this->buildFactory = $buildFactory;
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

        if ($this->config->admin->initialize ?? false) {
            $this->initialize();
            return '/';
        }

        if ($this->upgrade()) {
            return '/';
        }

        $this->relinkThemeRepos();
        $this->configs();
        $this->dateTime->setTimezone($this->config->general->timezone);

        $themeAutoload = $this->storage->path('_theme/vendor/autoload.php');
        require_once $themeAutoload;

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
        $this->storage->forceDir('_trash');

        $this->config('admin', '_argo/admin', [
            'lastBuild' => null,
            'lastSync' => null,
            'version' => null,
        ]);

        $this->config('blogroll', '_argo/blogroll', []);

        $this->config('featured', '_argo/featured', []);

        $this->config('general', '_argo/general', [
            'title' => '',
            'tagline' => '',
            'author' => '',
            'url' => '',
            'timezone' => $this->system->timezone(),
            'perPage' => 10,
            'theme' => 'argo/bootstrap4'
        ]);

        $this->config('menu', '_argo/menu', []);

        $this->config('sync', '_argo/sync', [
            'type' => 'git',
            'host' => '',
            'user' => '',
            'path' => '',
        ]);

        // load up the config for the theme as default values.
        $theme = $this->config->general->theme;
        $file = $this->system->docroot() ."/_theme/vendor/{$theme}/config/theme.json";
        $json = file_exists($file) ? file_get_contents($file) : '{}';
        $default = Json::decode($json, true);
        $this->config('theme', "_argo/theme/{$theme}", $default);
    }

    protected function config(string $name, string $id, array $default) : void
    {
        $old = isset($this->config->$name)
            ? $this->config->$name->getData()
            : null;

        if ($old === null) {
            // no existing config, create from default
            $this->config->save($this->config->new(
                $id,
                Json::recode($default)
            ));
            return;
        }

        $old = Json::recode($old, true);
        $new = array_replace_recursive($default, $old);
        if ($new !== $old) {
            // pre-existing config, write the changed values
            $this->config->$name->setData(Json::recode((object) $new));
            $this->config->save($this->config->$name);
        }
    }

    protected function initialize()
    {
        $this->initializeComposerThemes();

        $themeAutoload = $this->storage->path('_theme/vendor/autoload.php');
        require_once $themeAutoload;

        $this->configs();

        $text = [
            'Header set Cache-Control "no-cache, no-store, must-revalidate, max-age=0"',
            'Header set Expires "0"',
            'Header set Pragma "no-cache"',
        ];

        $this->storage->write('.htaccess', implode("\n", $text));

        $date = $this->dateTime->ymd();
        $relId = "{$date}/sample-post";
        $post = new Post(
            Post::absId($relId),
            [
                'title' => 'Sample Post',
                'author' => $this->config->general->author,
                'tags' => ['general'],
            ]
        );
        $this->content->posts->save($post, 'Sample post body.');
        $this->buildFactory->new()->all();

        unset($this->config->admin->initialize);
        $this->config->save($this->config->admin);
    }

    protected function upgrade() : bool
    {
        $version = $this->config->admin->version ?? '1.0.0';
        $method = 'upgradeFrom_' . str_replace('.', '_', $version);
        if (method_exists($this, $method)) {
            $this->$method();
            return true;
        }

        return false;
    }

    /**
     * @todo show composer output in log, but not in tests
     */
    protected function composer(string $command) : void
    {
        $composer = $this->system->approot() . '/bin/composer.phar';
        $docroot = $this->system->docroot() . '/_theme';
        $command = "cd $docroot; php $composer $command 2>&1";
        $this->system->exec($command);
    }

    protected function relinkThemeRepos() : void
    {
        $source = $this->system->approot() . '/resources/theme';
        $target = $this->system->supportDir();
        $command = "ln -sfn '{$source}' '{$target}/theme'";
        $this->system->exec($command);
    }

    protected function initializeComposerThemes() : void
    {
        $this->storage->forceDir('_theme');

        $this->relinkThemeRepos();

        $this->storage->write('_theme/composer.json', Json::encode([
            'name' => 'argo/themes',
            'description' => 'Argo themes for this site.',
            'license' => 'proprietary',
            'repositories' => [
                [
                    'type' => 'path',
                    'url' => $this->system->supportDir() . '/theme/original/',
                    'options' => [
                        'symlink' => true,
                    ],
                ],
                [
                    'type' => 'path',
                    'url' => $this->system->supportDir() . '/theme/bootstrap4/',
                    'options' => [
                        'symlink' => true,
                    ],
                ],
            ],
            'require' => [
                'argo/bootstrap4' => '>0@dev',
                'argo/original' => '>0@dev',
            ],
        ]));

        $this->composer('update');
    }

    protected function upgradeFrom_1_0_0() : void
    {
        $theme = $this->config->theme->name ?? 'argo/original';

        if ($theme == 'default') {
            $theme = 'argo/original';
        }

        $this->config->general->theme = $theme;
        $this->config->save($this->config->general);

        // copy the _argo/theme.json file to _argo/{$theme}.json;
        // e.g., from _argo/theme.json to _argo/theme/argo/original.json
        $this->storage->forceDir(dirname("_argo/theme/{$theme}"));
        $text = $this->storage->read('_argo/theme.json');
        $this->storage->write("_argo/theme/{$theme}.json", $text);

        // remove the old _argo/theme.json file
        $file = $this->storage->path('_argo/theme.json');
        $this->system->exec("rm {$file}");

        $this->config->admin->version = '1.0.0.u1';
        $this->config->save($this->config->admin);
    }

    protected function upgradeFrom_1_0_0_u1() : void
    {
        unset($this->config->theme->name);
        $this->config->save($this->config->theme);

        $this->initializeComposerThemes();

        $this->config->admin->version = '1.2.0';
        $this->config->save($this->config->admin);
    }
}
