<?php
namespace App\Applications\Api;

use App\Abstractions\Services as BaseServices;
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
        'router',
        'db',
        'registry',
        'translate',
        'session',
        'flashSession',
        'logger',
        'template',
    ];

    /**
     * Инициализация роутера
     */
    protected function setRouter()
    {
        $this->di->set('router', function () {
            $routes = new Routes();

            return $routes->getRouter();
        }, true);
    }
}
