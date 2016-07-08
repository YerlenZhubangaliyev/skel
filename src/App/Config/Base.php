<?php
namespace App\Config;

use Phalcon\Config;
use Phalcon\Logger\Adapter\File as FileLogger;
use Phalcon\Logger\Formatter\Line as LineFormatter;
use Phalcon\Translate\Adapter\ResourceBundle;

/**
 * Базовая конфигурация
 */
class Base extends Config
{

    /**
     * {@inheritdoc}
     */
    public function __construct()
    {
        parent::__construct([
            'locale'  => [
                'locale'   => 'ru_RU',
                'class'    => ResourceBundle::class,
                'bundle'   => '%s/data/locale/%s_%s',
                'fallback' => true,
            ],
            'mailing' => [
                'user'     => 'noreply@',
                'password' => '',
                'host'     => 'mail.',
                'port'     => 25,
            ],
            'cache'   => [
                'redis' => [
                    'prefix'     => '_skel',
                    'host'       => '127.0.0.1',
                    'port'       => 6379,
                    'auth'       => '',
                    'persistent' => false,
                    'index'      => 10,
                ],
            ],
            'error' => [
                'controller' => 'index',
                'action'     => 'error',
            ],
            'payment' => [
                'epay'   => [
                    
                ],
                'paybox' => [
                    'merchantId' => 0,
                    'secretKey'  => '__KEY__',
                    'currency'   => 'KZT',
                    'page'       => 'payment.php',
                    'url'        => [
                        'check'   => 'http://%1$s/%2$s/order/payment/check',
                        'result'  => 'http://%1$s/%2$s/order/payment/result',
                        'success' => 'http://%1$s/%2$s/order/payment/success',
                        'failure' => 'http://%1$s/%2$s/order/payment/failure',
                    ],
                ],
            ],
        ]);
    }

    /**
     * {@inheritdoc}
     *
     * @param  \Phalcon\Config $config
     *
     * @return \Phalcon\Config
     */
    public function merge(Config $config)
    {
        $result = array_replace_recursive($this->toArray(), $config->toArray());

        foreach ($result as $key => $value) {
            $this->offsetSet($key, $value);
        }

        return $this;
    }
}
