<?php
namespace App\Abstractions;

use App\Di;
use App\Traits\Cacheable;
use Phalcon\Mvc\Model;
use Phalcon\Text;

/**
 * Абстракция сущности
 */
abstract class Entity extends Model
{

    use Cacheable;

    /**
     * Идентификатор
     *
     * @var integer
     */
    protected $id;

    /**
     * Дополнительные сериализуемые свойства модели
     *
     * @var array
     */
    protected static $serializableProperties = [];

    /**
     * Сериализация полей из бд и дополнительных свойств из static::$serializableFields
     *
     * @return string
     */
    public function serialize()
    {
        $properties = [];
        $columns    = [];

        foreach ($this->columnMap() as $databaseName => $localName) {
            $columns[$localName] = $this->getProperty($localName);
        }

        $columns = serialize($columns);

        foreach (static::$serializableProperties as $name) {
            $properties[$name] = $this->getProperty($name);
        }

        $data = [
            'columns'    => $columns,
            'properties' => $properties,
        ];

        return serialize($data);
    }

    /**
     * Десериализация полей из бд и дополнительных свойств из static::$serializableFields
     *
     * @param  string $string
     *
     * @throws \Exception
     */
    public function unserialize($string)
    {
        $data = @unserialize($string);

        if ($data === false) {
            throw new \Exception(
                sprintf('Could not unserialize model of class %s from string %s', get_class($this), $string)
            );
        }

        if (isset($data['columns'])) {
            $columns = (array)unserialize($data['columns']);

            foreach ($columns as $localName => $value) {
                $this->setProperty($localName, $value);
            }
        }

        if (isset($data['properties'])) {
            foreach ($data['properties'] as $name => $value) {
                $this->setProperty($name, $value);
            }
        }

        $this->setDI(Di::getDefault());
        $this->_modelsManager = Di::getDefault()->getModelsManager();
        $this->_modelsManager->initialize($this);
    }

    /**
     * Устанавливает свойства модели через сеттеры после ее извлечения из бд
     */
    public function afterFetch()
    {
        foreach ($this->columnMap() as $property) {
            $this->setProperty($property, $this->{$property});
        }
    }

    /**
     * Возвращает модель в виде массива
     *
     * @param  array|null $columns
     *
     * @return array
     */
    public function toArray($columns = null)
    {
        $attributes = [];

        foreach ($this->columnMap() as $databaseName => $localName) {
            if ($columns && !in_array($localName, $columns)) {
                continue;
            }

            $attributes[$localName] = $this->getProperty($localName);
        }

        return $attributes;
    }

    /**
     * Возвращает массив моделей по заданным критериям
     *
     * @see \App\Abstractions\Entity::find()
     *
     * @param  array $parameters
     *
     * @return Entity[]
     */
    public static function findModels($parameters = null)
    {
        $results = static::find($parameters);
        $models  = [];

        foreach ($results as $result) {
            $models[] = $result;
        }

        return $models;
    }

    /**
     * Определяет, есть ли такое свойство у модели
     *
     * @param $name
     *
     * @return boolean
     */
    public function hasProperty($name)
    {
        return property_exists($this, $name);
    }

    /**
     * Определяет, есть ли такое свойство модели в таблице бд
     *
     * @param $name
     *
     * @return boolean
     */
    public function hasDatabaseProperty($name)
    {
        return in_array($name, $this->columnMap());
    }

    /**
     * Установка свойства модели через setter, если он сущестует и useSetter == true, либо напрямую
     *
     * @param string  $name
     * @param mixed   $value
     * @param boolean $useSetter
     */
    public function setProperty($name, $value, $useSetter = true)
    {
        $setter = 'set' . Text::camelize($name);

        if ($useSetter && method_exists($this, $setter)) {
            $this->$setter($value);
        } else {
            if (property_exists($this, $name)) {
                $this->$name = $value;
            }
        }
    }

    /**
     * Получение свойства модели через getter, если он сущестует, либо напрямую
     *
     * @param  string $name
     *
     * @return mixed
     */
    public function getProperty($name)
    {
        $getter = 'get' . Text::camelize($name);

        if (method_exists($this, $getter)) {
            return $this->$getter();
        } else {
            if (property_exists($this, $name)) {
                return $this->$name;
            }
        }

        return null;
    }

    /**
     * Возвращает массив сообщений с ошибками валидации в формате поле => сообщение
     *
     * @return array
     */
    public function getMessagesArray()
    {
        $result = [];
        foreach ($this->getMessages() as $message) {
            $result[$message->getField()] = $message->getMessage();
        }

        return $result;
    }

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param  integer $id
     *
     * @return \App\Abstractions\Entity
     */
    public function setId($id)
    {
        $this->id = (int)$id;

        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * @return array
     */
    public function columnMap()
    {
        $map = Di::getDefault()->getModelsMetadata()->getAttributes($this);

        return array_combine($map, $map);
    }

    /**
     * Переопределенный метод save нужен для его корректной замены в юнит-тестах
     *
     * {@inheritdoc}
     *
     * @param  array      $data
     * @param  array|null $whitelist
     *
     * @return boolean
     */
    public function save($data = [], $whiteList = null)
    {
        return parent::save($data, $whiteList);
    }
}
