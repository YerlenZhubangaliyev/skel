<?php
namespace App\Config;

use Phalcon\Config;

/**
 * Конфигурация в окружении "Development"
 */
class Development extends Staging
{

    /**
     * {@inheritdoc}
     */
    public function __construct()
    {
        parent::__construct();

        $this->merge(new Config([

        ]));
    }
}
