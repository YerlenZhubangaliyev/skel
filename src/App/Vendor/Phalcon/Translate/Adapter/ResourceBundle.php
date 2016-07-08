<?php
namespace App\Vendor\Phalcon\Translate\Adapter;

use Adoy\ICU\ResourceBundle\ResourceBundle as VendorResourceBundle;
use Adoy\ICU\ResourceBundle\Parser;
use Adoy\ICU\ResourceBundle\Lexer;
use Phalcon\Translate\Exception;
use Phalcon\Di;

/**
 * Класс для работы с переводами, хранящимися в txt.
 * Использовать следует только в режиме разработки.
 */
class ResourceBundle extends \Phalcon\Translate\Adapter\ResourceBundle
{

    /**
     * Экземлпяр класса - хранилища переводов
     *
     * @var \Adoy\ICU\ResourceBundle\ResourceBundle
     */
    protected $bundle;

    /**
     * Конструктор
     *
     * @param array $options
     *
     * @throws \Phalcon\Translate\Exception
     */
    public function __construct($options)
    {
        if (!is_array($options)) {
            throw new Exception('Invalid options');
        }

        if (!class_exists('\MessageFormatter')) {
            throw new Exception('"MessageFormatter" class is required');
        }

        if (!isset($options['locale'])) {
            throw new Exception('"locale" option is required');
        }

        $this->options = $options;
        $this->bundle  = new VendorResourceBundle(
            $this->options['locale'],
            sprintf(
                $this->options['bundle'],
                ROOT_DIR,
                Di::getDefault()->getRegistry()->application,
                Di::getDefault()->getRegistry()->module
            ),
            true,
            new Parser(new Lexer())
        );
    }

    /**
     * {@inheritdoc}
     *
     * @example               $this->get('labels.form.new')
     *
     * @param                                              $key
     * @param \Adoy\ICU\ResourceBundle\ResourceBundle|null $bundle
     *
     * @return string|boolean|\Adoy\ICU\ResourceBundle\ResourceBundle
     */
    public function get($key, $bundle)
    {
        $keyPath = explode(".", $key);

        if ($bundle instanceof VendorResourceBundle && !empty($keyPath)) {
            $bundle = $bundle->get($keyPath[0]);

            if (is_object($bundle)) {
                array_shift($keyPath);
                $keyValue = implode('.', $keyPath);

                return $this->get($keyValue, $bundle);
            } else {
                return $bundle;
            }
        }

        return false;
    }
}
