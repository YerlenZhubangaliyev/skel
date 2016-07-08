<?php
namespace App\View;

use App\Di;
use App\Traits\Translate;
use Phalcon\Mvc\View\Engine\Volt;

/**
 * Регистрация функций в компиляторе Volt
 */
class Functions
{

    use Translate {
        Translate::translate as translateQuery;
    }

    /**
     * Функции которые будут зарегистрированы
     *
     * @var array
     */
    protected $voltFunctions = [
        '_'           => 'translate',
        'dt'          => 'dateTime',
        'diffDays'    => 'diffDays',
        'round'       => 'round',
        'urldecode'   => 'urldecode',
        'url_locale'  => 'urlLocalized',
        'locale_name' => 'localeDisplayName',
        'html_strip'  => 'htmlStrip',
    ];

    /**
     * Экземпляр класса
     *
     * @var \Phalcon\Mvc\View\Engine\Volt
     */
    protected $compiler;

    /**
     * Конструктор
     *
     * @param \Phalcon\Mvc\View\Engine\Volt $volt
     */
    public function __construct(Volt $volt)
    {
        $this->compiler = $volt->getCompiler();

        $this->register();
    }

    /**
     * Регистрация функций в комплияторе Volt
     */
    private function register()
    {
        if ($this->voltFunctions) {
            foreach ($this->voltFunctions as $functionShortName => $functionLongName) {
                $this->compiler->addFunction(
                    $functionShortName,
                    function ($resolvedArgs, $exprArgs) use ($functionShortName, $functionLongName) {
                        return sprintf('%s::%s(%s)', __CLASS__, $functionLongName, $resolvedArgs);
                    }
                );
            }
        }
    }

    /**
     * @see \App\Traits\Translate::translate
     *
     * @param  array|string $index
     * @param  array        $placeholders
     *
     * @return mixed
     */
    public static function translate($index, array $placeholders = [])
    {
        return self::translateQuery($index, $placeholders);
    }

    /**
     * Алиас DateTime в volt
     *
     * @param string             $time
     * @param \DateTimeZone|null $timeZone
     *
     * @return \DateTime
     */
    public static function dateTime($time = 'now', \DateTimeZone $timeZone = null)
    {
        return new \DateTime($time, $timeZone);
    }

    /**
     * Округление числа
     *
     * @param integer|float $number
     * @param integer|float $precision
     *
     * @return \DateTime
     */
    public static function round($number, $precision = 2)
    {
        return round($number, $precision);
    }

    /**
     * Alias urldecode
     *
     * @param string $string
     *
     * @return \DateTime
     */
    public static function urldecode($string)
    {
        return urldecode($string);
    }

    /**
     * @param        $to
     * @param string $from
     *
     * @return mixed
     */
    public static function diffDays($to, $from = 'now')
    {
        $datetime1 = new \DateTime($from);
        $datetime2 = new \DateTime($to);
        $interval  = $datetime1->diff($datetime2);

        return $interval->days;
    }

    /**
     * @param $url
     * @param $locale
     *
     * @return string
     */
    public static function urlLocalized($url, $locale = null)
    {
        if (!$locale) {
            $locale = Di::getDefault()->getRegistry()->locale;
        }

        return \preg_replace("/([\/]{2,})/", "", '/' . $locale . '/' . $url);
    }

    /**
     * @param $localeTranslate
     * @param $locale
     *
     * @return string
     */
    public static function localeDisplayName($localeTranslate, $locale)
    {
        $languageName = \Locale::getDisplayLanguage($localeTranslate, $locale);

        return mb_strtoupper(mb_substr($languageName, 0, 1)) . mb_substr($languageName, 1);
    }

    /**
     * @param $string
     *
     * @return string
     */
    public static function htmlStrip($string)
    {
        return \strip_tags($string);
    }
}
