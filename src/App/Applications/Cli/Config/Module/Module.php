<?php
namespace App\Applications\Cli\Config\Module;

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
                        'Cli',
                        'Modules',
                    ],
                    'className' => 'Module',
                ],
                'modules'  => [
                    'main',
                    'admin',
                ],
            ],
        ]);
    }
}
