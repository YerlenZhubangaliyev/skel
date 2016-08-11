<?php
namespace App\Applications\Api;

use App\Routes as BaseRoutes;

/**
 * Api routes
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
