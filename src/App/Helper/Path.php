<?php
namespace App\Helper;

/**
 * Вспомогательные методы для работы с путями
 */
class Path
{

    /**
     * Разделитель для пространства имен классов
     *
     * @var string
     */
    public static $namespaceSeparator = '\\';

    /**
     * Разделитель для путей файловой системы
     *
     * @var string
     */
    public static $directorySeparator = \DIRECTORY_SEPARATOR;

    /**
     * Перевод массива в строку пути
     *
     * @param array   $inputArray
     * @param boolean $absolutePath
     * @param boolean $isFile
     * @param boolean $delimiter
     *
     * @return string
     */
    public static function arrayToPath(array $inputArray, $absolutePath = true, $isFile = true, $delimiter = false)
    {
        $delimiter = (!$delimiter) ? self::$directorySeparator : $delimiter;
        $result    = ($absolutePath) ? $delimiter : "";

        if (\is_array($inputArray) && \count($inputArray) > 0) {
            foreach ($inputArray as $inputArrayValue) {
                $inputArrayValue = \trim($inputArrayValue, $delimiter);
                $result .= $inputArrayValue . $delimiter;
            }
            if ($isFile) {
                $result = \rtrim($result, $delimiter);
            }
        }

        return $result;
    }

    /**
     * Перевод массива в строку PHP NAMESPACE
     *
     * @param array   $inputArray
     * @param boolean $absolutePath
     *
     * @return string
     */
    public static function arrayToNamespace(array $inputArray, $absolutePath = true)
    {
        return self::arrayToPath($inputArray, $absolutePath, true, self::$namespaceSeparator);
    }

    /**
     * Перевод строки пути в массив
     *
     * @param string $inputString
     *
     * @return array
     */
    public static function pathToArray($inputString)
    {
        $result = [];

        if (\is_string($inputString) && \strlen($inputString) > 0) {
            $result = \array_filter(\explode(self::$directorySeparator, $inputString));
        }

        return $result;
    }

    /**
     * @param string $inputString
     *
     * @return string
     */
    public static function parentDirectory($inputString)
    {
        $result = self::pathToArray($inputString);

        \array_pop($result);

        return self::arrayToPath($result);
    }
}
