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

/**
 * Main
 *
 * @property PhDI $this->diContainer
 */
class Main
{
    /**
     * @var null|PhMicro|PhCliConsole
     */
    protected $application = null;

    /**
     * @var null|DiInterface
     */
    protected $diContainer = null;

    /**
     * @var array
     */
    protected $options = [];

    /**
     * @var int
     */
    private $memory = 0;

    /**
     * @var int|mixed
     */
    private $executionTime = 0;

    /**
     * @var string
     */
    private $mode = 'development';

    public function __construct()
    {
        $this->memory        = memory_get_usage();
        $this->executionTime = microtime(true);
    }

    /**
     * Bootstraps the application
     *
     * @param DiInterface $diContainer
     *
     * @return mixed
     * @throws \Exception
     */
    public function run(DiInterface $diContainer)
    {
        /***********************************************************************
         * Di Container
         **********************************************************************/
        $this->diContainer = $diContainer;
        $this->diContainer::setDefault($diContainer);

        /***********************************************************************
         * Autoloader
         **********************************************************************/
        require_once APP_PATH . '/vendor/autoload.php';

        /***********************************************************************
         * .load
         **********************************************************************/
        (new Dotenv(APP_PATH))->load();

        $this->mode = getenv('APP_ENV');
        $this->mode = (false !== $this->mode) ? $this->mode : 'development';

        $this->initApplication();

        /***********************************************************************
         * Config
         **********************************************************************/
        $fileName = APP_PATH . '/app/config/config.php';
        if (true !== file_exists($fileName)) {
            throw new \Exception('Configuration file not found');
        }
        $configArray = require_once($fileName);
        $config = new PhConfig($configArray);

        $this->diContainer->setShared('config', $config);
        $this->diContainer->setShared('utils', new DocsUtils());

        $this->initServices();

        /***********************************************************************
         * cacheData
         **********************************************************************/
        $lifetime = $config->get('cache')->get('lifetime', 3600);
        $driver   = $config->get('cache')->get('driver', 'file');
        $frontEnd = new PhCacheFrontData(['lifetime' => $lifetime]);
        $backEnd  = ['cacheDir' => APP_PATH . '/storage/cache/data/'];
        $class    = sprintf('\Phalcon\Cache\Backend\%s', ucfirst($driver));
        $cache    = new $class($frontEnd, $backEnd);
        $this->diContainer->setShared('cacheData', $cache);

        /***********************************************************************
         * View
         **********************************************************************/
        $options = [
            'compiledPath'      => APP_PATH . '/storage/cache/volt/',
            'compiledSeparator' => '_',
            'compiledExtension' => '.php',
            'compileAlways'     => boolval('development' === $this->mode),
            'stat'              => true,
        ];
        $view    = new PhViewSimple();
        $view->setViewsDir(APP_PATH . '/app/views/');
        $view->registerEngines(
            [
                '.volt' => function ($view) use ($options) {
                    $volt  = new PhVolt($view, $this->diContainer);
                    $volt->setOptions($options);
                    $volt->getCompiler()
                         ->addFunction('str_repeat', 'str_repeat');
                    return $volt;
                },
            ]
        );
        $this->diContainer->setShared('viewSimple', $view);

        /***********************************************************************
         * Markdown
         **********************************************************************/
        $this->diContainer->setShared('parsedown', new PParseDown());

        /**
         * Run the application
         */
        return $this->runApplication();
    }

    /**
     * Initializes the application
     */
    protected function initApplication()
    {
        $this->application = new PhMicro($this->diContainer);
    }

    protected function initServices()
    {
        /** @var \Phalcon\Config $config */
        $config   = $this->diContainer->getShared('config');
        /** @var Utils $utils */
        $utils  = $this->diContainer->getShared('utils');
        /** @var PhEventsManager $eventsManager */
        $eventsManager = $this->diContainer->getShared('eventsManager');

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
        $this->application->mount($collection);
        $this->application->setEventsManager($eventsManager);

        /***********************************************************************
         * Logger
         **********************************************************************/
        $fileName  = $config->get('logger')
                            ->get('defaultFilename', 'application');
        $format    = $config->get('logger')
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
        $this->diContainer->setShared('logger', $logger);

        /***********************************************************************
         * viewCache
         **********************************************************************/
        $lifetime = $config->get('cache')->get('lifetime', 3600);
        $driver   = $config->get('cache')->get('viewDriver', 'file');
        $frontEnd = new PhCacheFrontOutput(['lifetime' => $lifetime]);
        $backEnd  = ['cacheDir' => APP_PATH . '/storage/cache/view/'];
        $class    = sprintf('\Phalcon\Cache\Backend\%s', ucfirst($driver));
        $cache    = new $class($frontEnd, $backEnd);
        $this->diContainer->set('viewCache', $cache);

        /***********************************************************************
         * Profiling and Error handling
         **********************************************************************/
        ini_set('display_errors', boolval('development' === $this->mode));
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

        /***********************************************************************
         * Assets
         **********************************************************************/
        /** @var PhAssetManager $assets */
        $assets = $this->diContainer->getShared('assets');
        $assets->collection("header_js");
        $assets
            ->collection('header_css')
            ->addCss('https://fonts.googleapis.com/css?family=Lato', false)
            ->addCss('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css', false)
            ->addCss('https://cdn.jsdelivr.net/highlight.js/9.9.0/styles/darcula.min.css', false)
            ->addCss($utils->getAsset('css/docs.css?v=' . time()));

        $assets
            ->collection('footer_js')
            ->addJs('https://code.jquery.com/jquery-3.1.1.min.js', false)
            ->addJs('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js', false)
            ->addJs('https://cdn.jsdelivr.net/highlight.js/9.9.0/highlight.min.js', false);
        $this->diContainer->setShared('assets', $assets);
    }

    /**
     * Runs the main application
     *
     * @return PhMicro
     */
    protected function runApplication()
    {
        return $this->application->handle();
    }
}
