<?php

namespace Docs\Cli\Tasks;

use Phalcon\CLI\Task as PhTask;

/**
 * MainTask
 */
class MainTask extends PhTask
{
    /**
     * This provides the main menu of commands if an command is not entered
     */
    public function mainAction()
    {

        echo '------------------------------------------------------' . PHP_EOL;
        echo ' Phalcon Blog' . PHP_EOL;
        echo '------------------------------------------------------' . PHP_EOL;
        echo PHP_EOL;
        echo 'Usage: phalcon <command>';

        echo PHP_EOL . PHP_EOL;

        $commands = [
            '  -clear-cache          Clears the cached files',
            '  -regenerate-api       Regenerates API documentation',
        ];

        echo 'Commands:' .  PHP_EOL;

        foreach ($commands as $command) {
            echo $command . PHP_EOL;
        }

        echo PHP_EOL;
    }
}
