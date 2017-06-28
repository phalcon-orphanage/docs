<?php

namespace Docs;

use Phalcon\Cli\Console as PhCliConsole;
use Phalcon\Cli\Dispatcher as PhCliDispatcher;

/**
 * Cli
 */
class Cli extends Main
{
    /**
     * Initializes the application
     */
    protected function initApplication()
    {
        $this->application = new PhCliConsole($this->diContainer);

        /**
         * Put the console in the diContainer because we need to use it in the
         * main task
         */
        $this->diContainer->setShared('console', $this->application);
    }

    /**
     * Initialize services for Cli
     */
    protected function initServices()
    {
        $dispatcher = new PhCliDispatcher();
        $dispatcher->setDefaultNamespace('Docs\Cli\Tasks');

        $this->diContainer->setShared('dispatcher', $dispatcher);

        $arguments = [];
        if (true === isset($_SERVER['argv'])) {
            foreach ($_SERVER['argv'] as $index => $argument) {
                switch ($index) {
                    case 1:
                        $arguments['task'] = $argument;
                        break;
                    case 2:
                        $arguments['action'] = $argument;
                        break;
                    case 3:
                        $arguments['params'] = $argument;
                        break;
                }
            }
        }

        $this->options = $arguments;
    }

    /**
     * Runs the main application
     *
     * @return PhCliConsole
     */
    protected function runApplication()
    {
        return $this->application->handle($this->options);
    }
}
