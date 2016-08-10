<?php
namespace App\Applications\Api;

use App\Abstractions\Services as BaseServices;
use Elasticsearch;
use Phalcon\Config as PhalconConfig;
use Phalcon\Mvc\Dispatcher as PhalconDispatcher;

/**
 * Api services
 */
class Services extends BaseServices
{

    /**
     * {@inheritdoc}
     *
     * @var array
     */
    protected $services = [
        'config',
        'registry',
        'router',
        'db',
        'translate',
        'session',
        'flashSession',
        'logger',
        'template',
        'elastic',
    ];

    /**
     * Инициализация роутера
     */
    protected function setRouter()
    {
        $this->di->set(
            'router',
            function () {
                $routes = new Routes();

                return $routes->getRouter();
            },
            true
        );
    }

    /**
     * ElasticSearch
     */
    protected function setElastic()
    {
        $this->di->set(
            'elastic',
            function () {
                if (isset($this->di->getConfig()->elastic->hosts)) {
                    $elastic = Elasticsearch\ClientBuilder
                        ::create()
                        ->setHosts($this->di->getConfig()->elastic->hosts)
                        ->build()
                    ;

                    return $elastic;
                }
            },
            true
        );
    }
}
