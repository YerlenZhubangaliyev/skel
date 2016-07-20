<?php
namespace App\Applications\Frontend;

use App\Routes as BaseRoutes;

/**
 * Frontend routes
 */
class Routes extends BaseRoutes
{

    /**
     * Routes constructor.
     */
    public function __construct()
    {
        static::$modules = (new Config\Module\Module())->toArray()['routes'];

        parent::__construct();
    }
}
