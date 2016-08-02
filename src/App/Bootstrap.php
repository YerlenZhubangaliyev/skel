<?php
namespace App;

use Composer\Autoload\ClassLoader;

/**
 * Bootstrap
 */
class Bootstrap
{

    /**
     * @var \App\Services
     */
    private $services;

    /**
     * @var \Composer\Autoload\ClassLoader
     */
    private $loader;

    /**
     * Конструктор
     *
     * @param \Composer\Autoload\ClassLoader $loader
     */
    public function __construct(ClassLoader $loader)
    {
        $this->loader = $loader;

        $this->setServices($loader);
    }

    /**
     * Инициализация сервисов
     *
     * @param \Composer\Autoload\ClassLoader $loader
     */
    public function setServices(ClassLoader $loader)
    {
        $configClass   = sprintf('App\Applications\%s\Config\%s', APPLICATION, ENVIRONMENT);
        $servicesClass = sprintf('App\Applications\%s\Services', APPLICATION);

        if (!$loader->loadClass($configClass)) {
            printf("Unable to load config class %s", $configClass);
            exit(1);
        }

        if (!$loader->loadClass($servicesClass)) {
            printf("Unable to load services class %s", $servicesClass);
            exit(1);
        }

        $this->services = new $servicesClass();

        Di::setDefault($this->services->getDi());
    }

    /**
     * Получаем сервисы
     *
     * @return mixed
     */
    public function getServices()
    {
        return $this->services;
    }
}
