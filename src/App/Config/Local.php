<?php
namespace App\Config;

use Phalcon\Config;
use App\Vendor\Phalcon\Translate\Adapter\ResourceBundle;

/**
 * Конфигурация в окружении "Local"
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
            'locale' => [
                'class'  => ResourceBundle::class,
                'bundle' => sprintf('%s/data/locale/%s/%s/txt'),
            ],
        ]));
    }
}
