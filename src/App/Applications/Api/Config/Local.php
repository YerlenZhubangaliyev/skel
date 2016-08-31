<?php
namespace App\Applications\Api\Config;

use Phalcon\Config;

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
