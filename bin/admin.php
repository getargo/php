<?php
$approot = dirname(__DIR__);

$open = PHP_OS_FAMILY === 'linux' ? 'xdg-open' : 'open';
$cmd = "{$open} http://127.0.0.1:8080/ && php {$approot}/bin/startup.php";
echo $cmd . PHP_EOL;
passthru($cmd); // blocks until terminal is closed

$cmd = "php {$approot}/bin/cleanup.php";
echo $cmd . PHP_EOL;
passthru($cmd);
