<?php
namespace App\Applications\Cli\Config;

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
                    'beanstalk' => [
                        'host' => '127.0.0.1',
                        'port' => 11300,
                    ],
                ]
            )
        );
    }
}
