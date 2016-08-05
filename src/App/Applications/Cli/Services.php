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
        'config',
        'registry',
        'router',
        'db',
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
}
