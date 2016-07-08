<?php
namespace App;

use Phalcon\Di\FactoryDefault;
use Phalcon\DiInterface;

/**
 * 
 */
class Di extends FactoryDefault implements DiInterface
{

    /**
     * @return Object|\ArrayAccess
     */
    public function getConfig()
    {
        return $this->getShared('registry')->config;
    }
}
