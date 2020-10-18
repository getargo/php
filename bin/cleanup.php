<?php
foreach (['8080', '8081'] as $port) {
    exec(
        "ps -x -o command=COMMAND---------------,pid | grep '^php -S 127.0.0.1:{$port}'",
        $output
    );

    if (! empty($output)) {
        $process = trim(array_shift($output));
        preg_match('/(\d+)$/', $process, $matches);
        $cmd = 'kill ' . (int) $matches[1];
        echo $cmd . PHP_EOL;
        exec($cmd);
    }
}
