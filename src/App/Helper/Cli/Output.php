<?php
namespace App\Helper\Cli;

/**
 * Вывод для консольных приложений
 */
class Output
{

    /**
     * Красный цвет текста
     *
     * @const FG_COLOR_RED
     */
    const FG_COLOR_RED = "\e[31m";

    /**
     * Красный цвет фона
     *
     * @const BG_COLOR_RED
     */
    const BG_COLOR_RED = "\e[41m";

    /**
     * Желтый цвет текста
     *
     * @const FG_COLOR_YELLOW
     */
    const FG_COLOR_YELLOW = "\e[33m";

    /**
     * Желтый цвет фона
     *
     * @const BG_COLOR_YELLOW
     */
    const BG_COLOR_YELLOW = "\e[43m";

    /**
     * Зеленый цвет текста
     *
     * @const FG_COLOR_GREEN
     */
    const FG_COLOR_GREEN = "\e[32m";

    /**
     * Зеленый цвет фона
     *
     * @const BG_COLOR_GREEN
     */
    const BG_COLOR_GREEN = "\e[42m";

    /**
     * Голубой цвет текста
     *
     * @const FG_COLOR_BLUE
     */
    const FG_COLOR_BLUE = "\e[34m";

    /**
     * Голубой цвет фона
     *
     * @const BG_COLOR_BLUE
     */
    const BG_COLOR_BLUE = "\e[44m";

    /**
     * Цвет текста "по-умолчанию"
     *
     * @const FG_COLOR_DEFAULT
     */
    const FG_COLOR_DEFAULT = "\e[0m";

    /**
     * Цвет фона "по-умолчанию"
     *
     * @const BG_COLOR_DEFAULT
     */
    const BG_COLOR_DEFAULT = "\e[49m";

    /**
     * Мерцающий текст
     *
     * @const TEXT_BLINK
     */
    const TEXT_BLINK = "\e[5m";

    /**
     * Жирный текст
     *
     * @const TEXT_BOLD
     */
    const TEXT_BOLD = "\e[1m";

    /**
     * Сбрасываем форматирование
     *
     * @const RESET_ALL
     */
    const RESET_ALL = "\e[0m";

    /**
     * STDERR
     *
     * @var string
     */
    protected static $error;

    /**
     * STDOUT
     *
     * @var string
     */
    protected static $out;

    /**
     * Получаем цветной текст
     *
     * @param $color
     * @param $string
     *
     * @return string
     */
    protected static function getColoredText($color = self::FG_COLOR_DEFAULT, $string)
    {
        return $color . $string . self::FG_COLOR_DEFAULT;
    }

    /**
     * Получаем цветной фон
     *
     * @param $color
     * @param $string
     *
     * @return string
     */
    protected static function getColoredBackground($color = self::BG_COLOR_DEFAULT, $string)
    {
        return $color . $string . self::BG_COLOR_DEFAULT;
    }

    /**
     * Вывод в stderr
     *
     * @param $message string
     */
    public static function error($message)
    {
        fwrite(STDERR, $message . PHP_EOL);
        self::$error .= $message . PHP_EOL;
    }

    /**
     * Вывод в stdout
     *
     * @param $message string
     */
    public static function out($message)
    {
        fwrite(STDOUT, $message . PHP_EOL);
        self::$out .= $message . PHP_EOL;
    }

    /**
     * Получаем stdout
     *
     * @return string
     */
    public static function getOut()
    {
        return self::$out;
    }

    /**
     * Получаем stderr
     *
     * @return string
     */
    public static function getError()
    {
        return self::$error;
    }

    /**
     * Очищаем вывод
     */
    public static function clear()
    {
        unset(self::$error);
        self::$error = '';

        unset(self::$out);
        self::$out = '';
    }
}
