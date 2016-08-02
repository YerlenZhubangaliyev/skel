<?php
namespace App\Abstractions;

use App\Di;
use App\View\Functions;
use App\Helper\Path as HelperPath;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Phalcon\Mvc\View;
use Phalcon\Mvc\View\Simple as ViewSimple;
use Phalcon\Config as PhalconConfig;
use Phalcon\Cache\Frontend\Data as CacheFrontendData;
use Phalcon\Cache\Backend\Redis as CacheBackendRedis;
use Phalcon\Events\Manager as PhalconEventsManager;
use Phalcon\Flash\Session as FlashSession;
use Phalcon\Session\Adapter\Files as Session;
use Phalcon\Registry;
use Phalcon\Mvc\View\Engine\Volt as VoltEngine;

/**
 * Базовые сервисы
 */
abstract class Services
{

    /**
     * Объект с конфигурацией приложения
     *
     * @var \Phalcon\Config
     */
    protected $config;

    /**
     * Объект, реализующий внедрение зависимостей
     *
     * @var \App\Di
     */
    protected $di;

    /**
     * Доступные сервисы
     *
     * @var array
     */
    protected $services = [
        'router',
        'db',
        'registry',
        'translate',
        'session',
        'template',
        'logger',
        'modelsCache',
    ];

    /**
     * Конструктор
     */
    public function __construct()
    {
        $this->di = new Di();

        $this->initialize();
    }

    /**
     * Возвращает объект Di
     *
     * @return \App\Di
     */
    public function getDi()
    {
        return $this->di;
    }

    /**
     * Инициализация доступных сервисов
     */
    protected function initialize()
    {
        foreach ($this->services as $service) {
            $methodName = 'set' . ucfirst($service);

            $this->{$methodName}();
        }
    }

    /**
     * Config initialization
     */
    public function setConfig()
    {
        $configClass = sprintf('App\Applications\%s\Config\%s', APPLICATION, ENVIRONMENT);

        $this->di->set(
            'config', function () use ($configClass) {
            return (new $configClass());
        }, true
        );
    }

    /**
     * Инициализация менеджера событий
     */
    protected function setEventsManager()
    {
        $this->di->set(
            'eventsManager', function () {
            $manager = new PhalconEventsManager();

            return $manager;
        }, true
        );
    }

    /**
     * Инициализация базы данных
     */
    protected function setDb()
    {
        $this->di->set(
            'db', function () {
            $className = sprintf('\Phalcon\Db\Adapter\Pdo\%s', $this->config->database->adapter);

            unset($this->config->database->adapter);

            /** @var \Phalcon\Db\Adapter $connection */
            $connection = new $className($this->config->database->toArray());

            return $connection;
        }, true
        );
    }

    /**
     * Инициализация реестра
     */
    protected function setRegistry()
    {
        $this->di->set(
            'registry', function () {
            $registry         = new Registry();
            $registry->config = $this->config;

            return $registry;
        }, true
        );
    }

    /**
     * Инициализация переводов
     */
    protected function setTranslate()
    {
        $this->di->set(
            'translate', function () {
            $configOptions = $this->di->getRegistry()->config->locale;
            $locale        =
                $this->di->getRegistry()->offsetExists('locale') ?
                    $this->di->getRegistry()->locale
                    : $configOptions['locale'];
            $class         = $configOptions->class;
            $translate     = new $class(
                array_merge(
                    $configOptions->toArray(), [
                                                 'locale' => $locale,
                                                 'bundle' => sprintf(
                                                     $configOptions->bundle, ROOT_DIR,
                                                     Di::getDefault()->getRegistry()->application,
                                                     Di::getDefault()->getRegistry()->module
                                                 ),
                                             ]
                )
            );

            return $translate;
        }, true
        );
    }

    /**
     * Общие шаблоны
     */
    protected function setTemplate()
    {
        $this->di->set(
            'template', function () {
            $viewDirectory         = sprintf("%s/src/App/View/Views/", ROOT_DIR);
            $view                  = new ViewSimple();
            $viewCompiledDirectory = HelperPath::arrayToPath(
                [
                    ROOT_DIR,
                    "cache",
                    "view",
                ],
                true,
                false
            );

            $view->setViewsDir($viewDirectory);
            $view->registerEngines(
                [
                    '.volt' => function ($view, $dependencyInjector) use ($viewCompiledDirectory) {
                        $volt = new VoltEngine($view, $dependencyInjector);
                        $volt->setOptions(
                            [
                                'compiledPath'  => $viewCompiledDirectory,
                                'stat'          => true,
                                'compileAlways' => true,
                            ]
                        );

                        new Functions($volt);

                        return $volt;
                    },
                ]
            );

            return $view;
        }, true
        );
    }

    /**
     * Инициализация сессии
     */
    protected function setSession()
    {
        $this->di->set(
            'session', function () {
            $session = new Session();
            $session->start();

            return $session;
        }, true
        );
    }

    /**
     * Flash сообщения
     */
    public function setFlashSession()
    {
        $this->di->set(
            'flashSession', function () {
            $flashSession = new FlashSession(
                [
                    'error'   => 'alert alert-danger',
                    'notice'  => 'alert alert-info',
                    'success' => 'alert alert-success',
                    'warning' => 'alert alert-warning',
                ]
            );

            return $flashSession;
        }, true
        );
    }

    /**
     * Logger
     */
    public function setLogger()
    {
        $this->di->set(
            'logger', function () {
            $logger = new Logger(
                sprintf(
                    '%s:%s',
                    APPLICATION,
                    ENVIRONMENT
                )
            );

            $logger->pushHandler(
                new StreamHandler(
                    sprintf(
                        "%s/logs/%s.log",
                        ROOT_DIR,
                        (new \DateTime('now'))->format('Y-m-d')
                    ),
                    Logger::DEBUG
                )
            );

            return $logger;
        }, true
        );
    }

    /**
     * Model caching
     */
    public function setModelsCache()
    {
        $this->di->set(
            'modelsCache', function () {
            $frontCacheData = new CacheFrontendData(
                [
                    "lifetime" => 86400,
                ]
            );

            $cache = new CacheBackendRedis(
                $frontCacheData,
                $this->di->getConfig()->cache->redis->toArray()
            );

            return $cache;
        }
        );
    }

    /**
     * Инициализация роутера
     */
    abstract protected function setRouter();
}
