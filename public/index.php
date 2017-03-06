<?php

use Docs\Main;

if (true !== defined('APP_PATH')) {
    define('APP_PATH', dirname(dirname(__FILE__)));
}

try {
    require_once APP_PATH . '/app/library/Docs/Main.php';

    /**
     * We don't want a global scope variable for this
     */
    (new Main())->run();

} catch (\Exception $e) {
    echo $e->getMessage() . PHP_EOL . $e->getTraceAsString();
}
