<?php
declare(strict_types=1);

namespace Argo\Infra;

use Argo\Domain\Log;
use Argo\Exception;
use DateTimeImmutable;
use RuntimeException;

class System
{
    protected $os;

    protected $log;

    public function __construct(Log $log, string $os = PHP_OS_FAMILY)
    {
        $this->log = $log;
        $this->os = $os;
    }

    public function exec(string $cmd, string $level = 'info') : void
    {
        $this->log->$level($cmd);
        $handle = popen($cmd, 'r');

        while (false !== $text = fgets($handle)) {
            $this->log->$level(rtrim($text));
        }

        pclose($handle);
    }

    public function open(string $file) : void
    {
        $cmd = $this->call(__FUNCTION__, $file);
        $this->exec($cmd);
    }

    public function timezone() : string
    {
        $time = shell_exec('export LC_ALL=en;date');
        $date = new DateTimeImmutable($time);
        $zone = $date->getTimeZone()->getName();
        switch ($zone) {
            case 'EDT':
                return 'EST5EDT';
            case 'CDT':
                return 'CST6CDT';
            case 'MDT':
                return 'MST7MDT';
            case 'PDT':
                return 'PST8PDT';
            default:
                return $zone;
        }
    }

    public function approot() : string
    {
        return dirname(__DIR__, 2);
    }

    public function docroot() : string
    {
        $file = $this->supportDir() . '/docroot.php';

        if (! file_exists($file)) {
            $docroot = '';
            $sites = $this->sites();

            if (! empty($sites)) {
                $docroot = array_shift($sites);
            }

            $this->putDocroot($docroot);
        }

        return require $file;
    }

    public function putDocroot(string $docroot) : void
    {
        $file = $this->supportDir() . '/docroot.php';
        file_put_contents($file, "<?php return '{$docroot}';");
    }

    public function sites() : array
    {
        $pattern = $this->sitesDir() . '/*/_argo';

        $dirs = glob($pattern, GLOB_ONLYDIR);
        $sites = [];

        foreach ($dirs as $dir) {
            $sites[basename(dirname($dir))] = dirname($dir) . '/';
        }

        return $sites;
    }

    public function homeDir() : string
    {
        return $this->call(__FUNCTION__);
    }

    public function sitesDir() : string
    {
        $dir = $this->call(__FUNCTION__);
        if (! is_dir($dir)) {
            $this->mkdir($dir);
        }
        return $dir;
    }

    public function supportDir() : string
    {
        $dir = $this->call(__FUNCTION__);
        if (! is_dir($dir)) {
            $this->mkdir($dir);
        }
        return $dir;
    }

    public function mkdir(string $dir) : void
    {
        $level = error_reporting(0);
        $result = mkdir($dir, 0755, true);
        error_reporting($level);

        if ($result !== false) {
            return;
        }

        $error = error_get_last();
        throw new RuntimeException($error['message'] . ": {$dir}");
    }

    public function whoami() : string
    {
        return trim(shell_exec('whoami'));
    }

    protected function call($func, ...$args)
    {
        $func = $this->os . ucfirst($func);
        return $this->$func(...$args);
    }

    protected function darwinOpen(string $file) : string
    {
        return "open {$file}";
    }

    protected function linuxOpen(string $file) : string
    {
        return "xdg-open {$file}";
    }

    protected function darwinHomeDir() : string
    {
        $user = $this->whoami();
        return "/Users/{$user}";
    }

    protected function linuxHomeDir() : string
    {
        $user = $this->whoami();
        return "/home/{$user}";
    }

    protected function darwinSitesDir() : string
    {
        return $this->homeDir() . '/Sites';
    }

    protected function linuxSitesDir() : string
    {
        return $this->homeDir() . '/Sites';
    }

    protected function darwinSupportDir() : string
    {
        return $this->homeDir() . '/Library/Application Support/Argo';
    }

    protected function linuxSupportDir() : string
    {
        return $this->homeDir() . '/.config/Argo';
    }
}
