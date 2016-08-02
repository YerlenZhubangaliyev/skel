<?php
namespace App\Traits;

use Phalcon\Di;
use Phalcon\DiInterface;

/**
 * Трейт, реализующий внедрение зависимости.
 */
trait DependencyInjection
{
    /**
     * Объект DI.
     *
     * @var \Phalcon\DiInterface
     */
    protected $di;

    /**
     * {@inheritdoc}
     *
     * @param \Phalcon\DiInterface $dependencyInjector
     */
    public function setDi(DiInterface $dependencyInjector)
    {
        $this->di = $dependencyInjector;
    }

    /**
     * {@inheritdoc}
     *
     * @return \App\Di
     */
    public function getDi()
    {
        if (null === $this->di) {
            $this->di = Di::getDefault();
        }

        return $this->di;
    }
}
