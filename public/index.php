<?php

use Docs\Main;
use Phalcon\Di\FactoryDefault as PhDi;

if (true !== defined('APP_PATH')) {
    define('APP_PATH', dirname(dirname(__FILE__)));
}

try {
    require_once APP_PATH . '/app/library/Main.php';

    /**
     * We don't want a global scope variable for this
     */
    (new Main())->run(new PhDi());

} catch (\Exception $e) {
    echo $e->getMessage() . PHP_EOL . $e->getTraceAsString();
}
