<?php
namespace App\Applications\Api\Config\Module;

use Phalcon\Config;

/**
 *
 * @package App\Applications\Frontend\Config\Module
 */
class Module extends Config
{

    /**
     * Module constructor.
     */
    public function __construct()
    {
        parent::__construct([
            'module' => [
                'settings' => [
                    'namespace' => [
                        'App',
                        'Applications',
                        'Frontend',
                        'Modules',
                    ],
                    'className' => 'Module',
                ],
                'modules'  => [
                    'main',
                    'admin',
                ],
            ],
            'routes' => [
                'main'  => [
                    'prefix'     => '',
                    'host'       => '',
                    'controller' => 'index',
                    'rules'      => [
                        [
                            'rule'   => '/',
                            'method' => ["get", "post", "put", "delete", "options"],
                            'action' => 'index',
                        ],
                        [
                            'rule'       => '/:controller',
                            'method'     => ["get", "post", "put", "delete", "options"],
                            'controller' => 1,
                        ],
                        [
                            'rule'       => '/:controller/:action',
                            'method'     => ["get", "post", "put", "delete", "options"],
                            'controller' => 1,
                            'action'     => 2,
                        ],
                        [
                            'rule'       => '/:controller/:action/:params',
                            'method'     => ["get", "post", "put", "delete", "options"],
                            'controller' => 1,
                            'action'     => 2,
                            'params'     => 3,
                        ],
                    ],
                ],
                'admin' => [
                    'prefix'     => '',
                    'host'       => 'admin.',
                    'controller' => 'index',
                    'rules'      => [
                        [
                            'rule'   => '/',
                            'method' => ["get", "post", "put", "delete", "options"],
                            'action' => 'index',
                        ],
                        [
                            'rule'       => '/:controller',
                            'method'     => ["get", "post", "put", "delete", "options"],
                            'controller' => 1,
                        ],
                        [
                            'rule'       => '/:controller/:action',
                            'method'     => ["get", "post", "put", "delete", "options"],
                            'controller' => 1,
                            'action'     => 2,
                        ],
                        [
                            'rule'       => '/:controller/:action/:params',
                            'method'     => ["get", "post", "put", "delete", "options"],
                            'controller' => 1,
                            'action'     => 2,
                            'params'     => 3,
                        ],
                    ],
                ],
            ],
        ]);
    }
}
