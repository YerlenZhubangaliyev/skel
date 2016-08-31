<?php
namespace App\Applications\Api\Config;

use App\Vendor\Phalcon\Translate\Adapter\ResourceBundle;
use Phalcon\Config;

/**
 * {@inheritdoc}
 */
class Development extends Staging
{

    /**
     * {@inheritdoc}
     */
    public function __construct()
    {
        parent::__construct();

        $this->merge(
            new Config(
                [
                    'application' => [
                        'domain' => '',
                        'host'   => '',
                    ],
                    'database'    => [
                        'adapter'  => 'Mysql',
                        'host'     => '127.0.0.1',
                        'username' => 'root',
                        'password' => '',
                        'dbname'   => '',
                        'charset'  => 'utf8',
                    ],
                    'locale'      => [
                        'class'    => ResourceBundle::class,
                        'bundle'   => '%s/data/locale/%s/%s/src/txt/',
                        'fallback' => true,
                    ],
                ]
            )
        );
    }
}
