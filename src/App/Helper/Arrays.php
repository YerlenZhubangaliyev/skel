<?php
namespace App\Helper;

/**
 * Вспомогательный класс для работы с массивами
 */
class Arrays
{

    /**
     * Конвертирует значения в UPPERCASE в одномерном массиве
     *
     * @param array $inputArray
     *
     * @return array
     */
    public static function arrayValuesToUpper(array $inputArray)
    {
        return \array_map(function ($value) {
            return \strtoupper($value);
        }, $inputArray);
    }

    /**
     * Конвертирует значения в LOWERCASE в одномерном массиве
     *
     * @param array $inputArray
     *
     * @return array
     */
    public static function arrayValuesToLower(array $inputArray)
    {
        return \array_map(function ($value) {
            return \strtolower($value);
        }, $inputArray);
    }

    /**
     * Конвертирует ключи в UPPERCASE в одномерном массиве
     *
     * @param array $inputArray
     *
     * @return array
     */
    public static function arrayKeysToUpper(array $inputArray)
    {
        return \array_change_key_case($inputArray, \CASE_UPPER);
    }

    /**
     * Конвертирует ключи в LOWERCASE в одномерном массиве
     *
     * @param array $inputArray
     *
     * @return array
     */
    public static function arrayKeysToLower(array $inputArray)
    {
        return \array_change_key_case($inputArray, \CASE_LOWER);
    }

    /**
     * Получение значения из многомерного массива по одному или нескольким ключам.
     * Если такого ключа не существует, вернется значение по-умолчанию.
     *
     * @see https://github.com/igorw/get-in
     *
     * @param  array        $array
     * @param  array|string $keys
     * @param  mixed|null   $default
     *
     * @return array|mixed|null
     */
    public static function getIn(array $array, $keys, $default = null)
    {
        if (!$keys) {
            return $array;
        }

        if (is_string($keys)) {
            $keys = [$keys];
        }

        if (count($keys) === 1 && isset($array[$keys[0]])) {
            return $array[$keys[0]];
        }

        $current = $array;

        foreach ($keys as $key) {
            if (!array_key_exists($key, $current)) {
                return $default;
            }

            $current = $current[$key];
        }

        return $current;
    }

    /**
     * Установка значения в многомерный ассоциативный массив
     *
     * @see https://github.com/igorw/get-in
     *
     * @param  array        $array
     * @param  array|string $keys
     * @param  mixed        $value
     *
     * @return array
     */
    public static function setAssocIn(array $array, $keys, $value)
    {
        if (!$keys) {
            return $array;
        }

        if (is_string($keys)) {
            $keys = [$keys];
        }

        $current = &$array;

        foreach ($keys as $key) {
            if (!is_array($current)) {
                $current = [];
            }

            $current = &$current[$key];
        }

        $current = $value;

        return $array;
    }
}
