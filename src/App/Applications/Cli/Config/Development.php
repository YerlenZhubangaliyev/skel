<?php
namespace App\Applications\Cli\Config;

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
                        'name'    => 'skel cli',
                        'version' => 1,
                    ],
                    'beanstalk'   => [
                        'host'   => '192.168.9.240',
                        'prefix' => '',
                    ],
                ]
            )
        );
    }
}
