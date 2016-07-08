<?php
namespace App\Helper\Cli;

/**
 * Вспомогательный класс для консольных аргументов
 */
class Options
{

    /**
     * Возвращает опции для \Phalcon\CLI\Console::handle
     *
     * @return array
     */
    public static function getOptions()
    {
        $arguments = $_SERVER['argv'];
        $result    = [];

        array_shift($arguments);

        if ($arguments && count($arguments) >= 1) {
            $result['module'] = $arguments[0];
            $result['task']   = $arguments[1];
            $result['action'] = (isset($arguments[2])) ? $arguments[2] : null;
            $result['params'] = array_slice($arguments, 3);
        }

        return $result;
    }
}
