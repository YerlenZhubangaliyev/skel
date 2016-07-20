<?php
namespace App\Applications\Frontend;

use App\Routes as BaseRoutes;

/**
 * Роуты для Frontend
 */
class Routes extends BaseRoutes
{
    public function __construct()
    {
        static::$modules = (new Config\Module\Module())->toArray()['routes'];

        parent::__construct();
    }
}
