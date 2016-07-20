<?php
namespace App\Abstractions\Database;

/**
 * Class Repository
 * @package App\Abstractions
 */
abstract class Repository
{
    /**
     * Имя класса сущности
     *
     * @var string
     */
    protected static $entityClass;

    /**
     * Возвращает новый объект сущности
     *
     * @return \App\Abstractions\Entity
     * @throws \Exception
     */
    protected function getEntity()
    {
        if (!static::$entityClass) {
            throw new \Exception('EntityClass is not defined');
        } elseif (class_exists(static::$entityClass)) {
            return new static::$entityClass();
        } else {
            throw new \Exception('No such entity: ' . static::$entityClass);
        }
    }
}
