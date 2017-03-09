<?php

namespace Docs;

use Dotenv\Dotenv;

use Phalcon\Assets\Manager;
use Phalcon\Cache\Frontend\Data as PhCacheFrontData;
use Phalcon\Cache\Frontend\Output as PhCacheFrontOutput;
use Phalcon\Config as PhConfig;
use Phalcon\Di as PhDI;
use Phalcon\Escaper as PhEscaper;
use Phalcon\Events\Manager as PhEventsManager;
use Phalcon\Http\Request as PhRequest;
use Phalcon\Http\Response as PhResponse;
use Phalcon\Logger\Adapter\File as PhFileLogger;
use Phalcon\Logger\Formatter\Line as PhLoggerFormatter;
use Phalcon\Mvc\Micro as PhMicro;
use Phalcon\Mvc\Micro\Collection as PhMicroCollection;
use Phalcon\Mvc\Router as PhRouter;
use Phalcon\Mvc\Url as PhUrl;
use Phalcon\Mvc\View\Simple as PhViewSimple;
use Phalcon\Mvc\View\Engine\Volt as PhVolt;
use Phalcon\Tag as PhTag;

use ParsedownExtra as PParseDown;
use Docs\Locale as DocsLocale;
use Docs\Utils as DocsUtils;

/**
 * Main
 *
 * @property PhDI $diContainer
 */
class Main
{
    public function run()
    {
        /**
         * Autoloader
         */
        require_once APP_PATH . '/vendor/autoload.php';

        /**
         * .load
         */
        (new Dotenv(APP_PATH))->load();

        /**
         * Profiling and application mode
         */
        $executionTime = microtime(true);
        $memory        = memory_get_usage();
        $mode          = getenv('APP_ENV');
        $mode          = (false !== $mode) ? $mode : 'development';

        /**
         * Config
         */
        $fileName = APP_PATH . '/app/config/config.php';
        if (true !== file_exists($fileName)) {
            throw new \Exception('Configuration file not found');
        }
        $configArray = require_once($fileName);

        /**
         * Set the Di Container
         */
        $diContainer = new PhDI();
        PhDI::setDefault($diContainer);

        $application = new PhMicro($diContainer);

        /**
         * Assets
         */
        $assets = new Manager();
        $diContainer->setShared('assets', $assets);

        /**
         * Config
         */
        $config = new PhConfig($configArray);
        $diContainer->setShared('config', $config);

        /**
         * Escaper
         */
        $escaper = new PhEscaper();
        $diContainer->setShared('escaper', $escaper);

        /**
         * Events Manager
         */
        $eventsManager = new PhEventsManager();
        $diContainer->setShared('eventsManager', $eventsManager);

        /**
         * Request
         */
        $request = new PhRequest();
        $diContainer->setShared('request', $request);

        /**
         * Response
         */
        $response = new PhResponse();
        $diContainer->setShared('response', $response);

        /**
         * Router
         */
        $router = new PhRouter();
        $diContainer->setShared('router', $router);

        /**
         * Url
         */
        $url = new PhUrl();
        $diContainer->setShared('url', $url);

        /**
         * Tag
         */
        $tag = new PhTag();
        $diContainer->setShared('tag', $tag);

        /**
         * Locale
         */
        $locale = new DocsLocale();
        $diContainer->setShared('locale', $locale);

        /**
         * Utils
         */
        $utils = new DocsUtils();
        $diContainer->setShared('utils', $utils);

        /**
         * Logger
         */
        $fileName = $config->get('logger')
                           ->get('defaultFilename', 'application');
        $format   = $config->get('logger')
                           ->get('format', '[%date%][%type%] %message%');

        $logFile   = sprintf(
            '%s/storage/logs/%s-%s.log',
            APP_PATH,
            date('Ymd'),
            $fileName
        );
        $formatter = new PhLoggerFormatter($format);
        $logger    = new PhFileLogger($logFile);
        $logger->setFormatter($formatter);
        $diContainer->setShared('logger', $logger);

        /**
         * viewCache
         */
        /** @var \Phalcon\Config $config */
        $config   = $diContainer->getShared('config');
        $lifetime = $config->get('cache')->get('lifetime', 3600);
        $driver   = $config->get('cache')->get('viewDriver', 'file');
        $frontEnd = new PhCacheFrontOutput(['lifetime' => $lifetime]);
        $backEnd  = ['cacheDir' => APP_PATH . '/storage/cache/view/'];
        $class    = sprintf('\Phalcon\Cache\Backend\%s', ucfirst($driver));
        $cache    = new $class($frontEnd, $backEnd);
        $diContainer->set('viewCache', $cache);

        /**
         * cacheData
         */
        $driver   = $config->get('cache')->get('driver', 'file');
        $frontEnd = new PhCacheFrontData(['lifetime' => $lifetime]);
        $backEnd  = ['cacheDir' => APP_PATH . '/storage/cache/data/'];
        $class    = sprintf('\Phalcon\Cache\Backend\%s', ucfirst($driver));
        $cache    = new $class($frontEnd, $backEnd);
        $diContainer->setShared('cacheData', $cache);

        /**
         * Profiling and Error handling
         */
        ini_set('display_errors', boolval('development' === $mode));
        error_reporting(E_ALL);

        set_error_handler(
            function ($errorNumber, $errorString, $errorFile, $errorLine) use ($logger) {
                if (0 === $errorNumber & 0 === error_reporting()) {
                    return;
                }

                $logger->error(
                    sprintf(
                        "[%s] [%s] %s - %s",
                        $errorNumber,
                        $errorLine,
                        $errorString,
                        $errorFile
                    )
                );
            }
        );

        set_exception_handler(
            function () use ($logger) {
                $logger->error(json_encode(debug_backtrace()));
            }
        );

        register_shutdown_function(
            function () use ($logger, $utils, $mode, $executionTime, $memory) {
                $memory    = memory_get_usage() - $memory;
                $execution = microtime(true) - $executionTime;

                if ('development' === $mode) {
                    $logger->info(
                        sprintf(
                            'Shutdown completed [%s] - [%s]',
                            $utils->timeToHuman($execution),
                            $utils->bytesToHuman($memory)
                        )
                    );
                }
            }
        );

        /**
         * Routes
         */
        $routes     = $config->get('routes')->toArray();
        $collection = new PhMicroCollection();
        $collection->setHandler($routes['class'], true);
        if (true !== empty($routes['prefix'])) {
            $collection->setPrefix($routes['prefix']);
        }

        foreach ($routes['methods'] as $verb => $methods) {
            foreach ($methods as $endpoint => $action) {
                $collection->$verb($endpoint, $action);
            }
        }
        $application->mount($collection);
        $application->setEventsManager($eventsManager);

        /**
         * View
         */
        $options = [
            'compiledPath'      => APP_PATH . '/storage/cache/volt/',
            'compiledSeparator' => '_',
            'compiledExtension' => '.php',
            'compileAlways'     => boolval('development' === $mode),
            'stat'              => true,
        ];
        $view    = new PhViewSimple();
        $view->setViewsDir(APP_PATH . '/app/views/');
        $view->registerEngines(
            [
                '.volt' => function ($view) use ($options, $diContainer) {
                    $volt  = new PhVolt($view, $diContainer);
                    $volt->setOptions($options);

                    return $volt;
                },
            ]
        );
        $diContainer->setShared('viewSimple', $view);

        /**
         * Assets
         */
        $assets->collection("header_js");
        $assets
            ->collection('header_css')
            ->addCss('https://fonts.googleapis.com/css?family=Ubuntu:regular,bold,italic', false)
            ->addCss('https://cdn.jsdelivr.net/highlight.js/9.9.0/styles/darcula.min.css', false)
            ->addCss($utils->getAsset('css/toolkit.css'))
            ->addCss($utils->getAsset('css/application.css'))
            ->addCss($utils->getAsset('css/docs.css'));

        $assets
            ->collection('footer_js')
            ->addJs('https://cdn.jsdelivr.net/highlight.js/9.9.0/highlight.min.js', false)
            ->addJs($utils->getAsset('js/jquery.min.js'))
            ->addJs($utils->getAsset('js/chart.js'))
            ->addJs($utils->getAsset('js/toolkit.js'))
            ->addJs($utils->getAsset('js/application.js'));
        $diContainer->setShared('assets', $assets);

        /**
         * Markdown
         */
        $parsedown = new PParseDown();
        $diContainer->setShared('parsedown', $parsedown);

        return $application->handle();
    }
}
