<?php

/**
 * Register the autoloader and tell it to register the src/ directory
 */
$loader = new \Phalcon\Loader();

$loader->registerNamespaces(
    [
        "PhalconDocs" => __DIR__ . "/scripts/src/",
    ]
);

$loader->register();



// Using the CLI factory default services container
$di = new \Phalcon\Di\FactoryDefault\Cli();



$di->setShared(
    "dispatcher",
    function () {
        $dispatcher = new \Phalcon\Cli\Dispatcher();

        $dispatcher->setDefaultNamespace("PhalconDocs\\Task");

        return $dispatcher;
    }
);



// Create a console application
$console = new \Phalcon\Cli\Console();

$console->setDI($di);



/**
 * Process the console arguments
 */
$arguments = [];

foreach ($argv as $k => $arg) {
    if ($k == 1) {
        $arguments["task"] = $arg;
    } elseif ($k == 2) {
        $arguments["action"] = $arg;
    } elseif ($k >= 3) {
        $arguments["params"][] = $arg;
    }
}



try {
    // Handle incoming arguments
    $console->handle($arguments);
} catch (\Exception $exception) {
    fwrite(
        STDERR,
        "ERROR: " . $exception->getMessage() . PHP_EOL
    );

    exit(1);
}
