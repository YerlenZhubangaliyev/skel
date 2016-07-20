<?php
namespace App\Applications\Api\Config;

use App\Application;
use App\Vendor\Phalcon\Translate\Adapter\ResourceBundle;
use Phalcon\Config;
use Phalcon\Di;

/**
 * {@inheritdoc}
 */
class Local extends Development
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
                ]
            )
        );
    }
}
