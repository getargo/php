<?php
$approot = dirname(__DIR__);

$args = implode(' ', [
    "-S 127.0.0.1:8080",
    "-t {$approot}/public/",
    "-d post_max_size=50M",
    "-d upload_max_filesize=50M",
]);

$cmd = "php {$args}";
echo $cmd . PHP_EOL;

$handle = popen($cmd, 'r');
while (! feof($handle)) {
    echo fread($handle, 8192);
}
pclose($handle);
