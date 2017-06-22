<?php

namespace Docs;

use Dotenv\Dotenv;

use Phalcon\Assets\Manager as PhAssetManager;
use Phalcon\Cache\Frontend\Data as PhCacheFrontData;
use Phalcon\Cache\Frontend\Output as PhCacheFrontOutput;
use Phalcon\Cli\Console as PhCliConsole;
use Phalcon\Config as PhConfig;
use Phalcon\Di\FactoryDefault as PhDI;
use Phalcon\DiInterface;
use Phalcon\Events\Manager as PhEventsManager;
use Phalcon\Logger\Adapter\File as PhFileLogger;
use Phalcon\Logger\Formatter\Line as PhLoggerFormatter;
use Phalcon\Mvc\Micro as PhMicro;
use Phalcon\Mvc\Micro\Collection as PhMicroCollection;
use Phalcon\Mvc\View\Simple as PhViewSimple;
use Phalcon\Mvc\View\Engine\Volt as PhVolt;

use ParsedownExtra as PParseDown;
use Docs\Utils as DocsUtils;
use Phalcon\Registry;

/**
 * Test
 *
 * @property PhDI $this->diContainer
 */
class Test extends Main
{
    /**
     * Runs the main application
     *
     * @return PhMicro
     */
    protected function runApplication()
    {
        return $this->application;
    }
}
