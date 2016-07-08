<?php
namespace App;

use Composer\Autoload\ClassLoader;

/**
 * Класс инициализации приложения
 */
abstract class Application
{

    /**
     * Автозагрузчик классов
     *
     * @var \Composer\Autoload\ClassLoader
     */
    public $loader;

    /**
     * Экземпляр класса
     *
     * @var \App\Bootstrap
     */
    protected $bootstrap;

    /**
     * Конструктор
     *
     * @param \Composer\Autoload\ClassLoader $loader
     */
    abstract public function __construct(ClassLoader $loader);

    /**
     * Инициализация приложения
     *
     * @return string
     */
    abstract public function handle();
}
