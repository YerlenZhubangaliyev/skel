<?php
namespace App\Traits;

use App\Di;

/**
 * Переводы
 */
trait Translate
{

    /**
     * @see \Phalcon\Translate\Adapter\ResourceBundle::query
     *
     * Если первым аргументом передан массив, то его первый элемент будет строкой для перевода,
     * а остальные - переменными.
     *
     * @param  array|string $index
     * @param  array        $placeholders
     *
     * @return string
     */
    public static function translate($index, array $placeholders = [])
    {
        if (is_array($index)) {
            $placeholders = array_slice($index, 1, null, true);
            $index        = $index[0];
        }

        // @TODO Сделать с этим что-нибудь
        if (isset(Di::getDefault()->getRegistry()->translateDebug) && true === Di::getDefault()->getRegistry()->translateDebug) {
            return $index;
        }

        return Di::getDefault()->getTranslate()->query($index, $placeholders);
    }

    /**
     * Вызов \App\Traits\Translate::_ в контексте объекта
     *
     * @param string $index
     * @param array  $placeholders
     *
     * @return mixed
     */
    public function _($index, array $placeholders = [])
    {
        return self::translate($index, $placeholders);
    }
}
