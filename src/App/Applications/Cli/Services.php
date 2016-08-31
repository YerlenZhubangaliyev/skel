<?php
namespace App\Applications\Cli;

use App\Abstractions\Services as BaseServices;
use Elasticsearch;
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
        'logger',
        'template',
        'elastic',
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
                        ->setLogger($this->di->getLogger())
                        ->build()
                    ;

                    return $elastic;
                }
            },
            true
        );
    }
}
