<?php
namespace App\Applications\Cli;

use App\Abstractions\Services as BaseServices;
use Phalcon\Cli\Router as PhalconRouter;
use Phalcon\Cli\Dispatcher as PhalconDispatcher;

/**
 * Cli services
 */
final class Services extends BaseServices
{

    /**
     * @var array
     */
    protected $services = [
        'router',
        'db',
        'registry',
        'dispatcher',
        'logger',
        'template',
    ];

    /**
     * {@inheritdoc}
     */
    public function initialize()
    {
        parent::initialize();
    }

    /**
     * {@inheritdoc}
     */
    protected function setRouter()
    {
        $this->di->set('router', function () {
            return new PhalconRouter();
        }, true);
    }

    /**
     * {@inheritdoc}
     */
    protected function setDispatcher()
    {
        $this->di->set('dispatcher', function () {
            $dispatcher = new PhalconDispatcher();
            $dispatcher->setDefaultNamespace(sprintf('App\Applications\%s\Task', APPLICATION));
            $dispatcher->setEventsManager($this->di->getEventsManager());

            return $dispatcher;
        }, true);
    }
}
