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

                ]
            )
        );
    }
}
