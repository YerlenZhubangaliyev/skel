<?php
namespace App\Vendor\Payment;

/**
 * Paybox.kz
 *
 * @link http://paybox.kz
 */
class Paybox
{

    /**
     * Макс. длина соли
     */
    const SALT_MAX_LENGTH = 6;

    /**
     * Url для оплаты
     */
    const PAYMENT_URL = 'https://paybox.kz/payment.php?';

    /**
     * @var integer
     */
    protected $merchantId;

    /**
     * @var string
     */
    protected $secretKey;

    /**
     * @var string
     */
    protected $currency;

    /**
     * @var string
     */
    protected $language;

    /**
     * @var mixed
     */
    protected $orderId;

    /**
     * @var float
     */
    protected $amount;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var string
     */
    protected $urlPage;

    /**
     * @var array
     */
    protected $urls;

    /**
     * @param string
     */
    protected $paymentSystem;

    /**
     * @var integer
     */
    protected $testMode = 0;

    /**
     * @param integer $merchantId
     * @param string  $secretKey
     */
    public function __construct($merchantId, $secretKey)
    {
        $this->merchantId = $merchantId;
        $this->secretKey  = $secretKey;
    }

    /**
     * @return string
     */
    public function createRequest()
    {
        $requestData = [
            'pg_amount'         => $this->amount,
            'pg_currency'       => $this->currency,
            'pg_description'    => $this->description,
            'pg_language'       => $this->language,
            'pg_merchant_id'    => $this->merchantId,
            'pg_order_id'       => $this->orderId,
            'pg_payment_system' => $this->paymentSystem,
            'pg_testing_mode'   => $this->testMode,
            'pg_salt'           => $this->getSalt(),
        ];

        $requestData = array_merge($requestData, $this->urls);
        $requestData = array_merge($requestData, [
            'pg_sig' => $this->getSignature($this->urlPage, $requestData),
        ]);

        return self::PAYMENT_URL . http_build_query($requestData);
    }

    /**
     * @param         $root
     * @param array   $tags
     * @param boolean $formatOutput
     *
     * @return string
     */
    public function createXmlDocument($root, array $tags = [], $formatOutput = true)
    {
        $xmlDocument = new \DOMDocument('1.0', 'utf-8');
        $rootElement = $xmlDocument->createElement($root);

        $xmlDocument->appendChild($rootElement);

        if (!empty($tags)) {
            foreach ($tags as $tagKey => $tagValue) {
                $rootElement->appendChild($xmlDocument->createElement(trim($tagKey), trim($tagValue)));
            }

            $xmlDocument->formatOutput = $formatOutput;
        }

        return $xmlDocument->saveXML();
    }

    /**
     * @param  array $urls
     * @param  array $params
     *
     * @return \App\Vendor\Payment\Paybox
     */
    public function setUrls(array $urls = [], ...$params)
    {
        foreach ($urls as $urlKey => $urlValue) {
            $this->urls['pg_' . $urlKey . '_url'] = \vsprintf($urlValue, array_merge($params));
        }

        return $this;
    }

    /**
     * @param  string $urlPage
     * @param  array  $params
     *
     * @return string
     */
    public function getSignature($urlPage, array $params = [])
    {
        ksort($params, SORT_STRING);

        $params = array_merge([$urlPage], array_values($params), [$this->secretKey]);

        return hash('md5', implode(';', $params));
    }

    /**
     * @return string
     */
    public function getSalt()
    {
        return substr(hash('md5', uniqid(rand(), true)), 0, self::SALT_MAX_LENGTH);
    }

    /**
     * @param  string $currency
     *
     * @return \App\Vendor\Payment\Paybox
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * @param  string $language
     *
     * @return \App\Vendor\Payment\Paybox
     */
    public function setLanguage($language)
    {
        $this->language = $language;

        return $this;
    }

    /**
     * @param  mixed $orderId
     *
     * @return \App\Vendor\Payment\Paybox
     */
    public function setOrderId($orderId)
    {
        $this->orderId = $orderId;

        return $this;
    }

    /**
     * @param  mixed $amount
     *
     * @return \App\Vendor\Payment\Paybox
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * @param  string $description
     *
     * @return \App\Vendor\Payment\Paybox
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @param  string $urlPage
     *
     * @return \App\Vendor\Payment\Paybox
     */
    public function setUrlPage($urlPage)
    {
        $this->urlPage = $urlPage;

        return $this;
    }

    /**
     * @param string $paymentSystem
     *
     * @return \App\Vendor\Payment\Paybox
     */
    public function setPaymentSystem($paymentSystem)
    {
        $this->paymentSystem = $paymentSystem;

        return $this;
    }

    /**
     * @param integer $testMode
     *
     * @return \App\Vendor\Payment\Paybox
     */
    public function setTestMode($testMode)
    {
        $this->testMode = (int) $testMode;

        return $this;
    }

    /**
     * @param array    $requestData
     * @param callable $check
     *
     * @return string
     */
    public function result(array $requestData = [], callable $check)
    {
        $xmlResponse = [];

        if (!empty($requestData)) {
            $orderId   = $requestData['pg_order_id'];
            $salt      = $requestData['pg_salt'];
            $result    = $requestData['pg_result'];
            $signature = $requestData['pg_sig'];
            $params    = [
                'pg_status' => 'ok',
                'pg_salt'   => $salt,
            ];

            unset($requestData['pg_sig']);

            if ($signature !== $this->getSignature('result', $requestData)) {
                $params['pg_status']            = 'error';
                $params['pg_error_code']        = 100;
                $params['pg_error_description'] = 'incorrect_signature';
            } else {
                if (true === $check($result, $orderId)) {
                    $params['pg_status']      = 'ok';
                    $params['pg_description'] = 'payment_success';
                }
            }

            if (isset($params['pg_status']) && $params['pg_status'] == 'ok') {
                $xmlResponse = [
                    'pg_salt'        => $params['pg_salt'],
                    'pg_status'      => 'ok',
                    'pg_description' => $params['pg_description'],
                    'pg_sig'         => $this->getSignature('result', $params),
                ];
            } else {
                $xmlResponse = [
                    'pg_salt'              => $params['pg_salt'],
                    'pg_status'            => 'error',
                    'pg_error_code'        => $params['pg_error_code'],
                    'pg_error_description' => $params['pg_error_description'],
                    'pg_sig'               => $this->getSignature('result', $params),
                ];
            }
        }

        return $this->createXmlDocument('response', $xmlResponse);
    }

    /**
     * @param array    $requestData
     * @param callable $check
     *
     * @return string
     */
    public function check(array $requestData = [], callable $check)
    {
        $xmlResponse = [];

        if (!empty($requestData)) {
            $orderId   = $requestData['pg_order_id'];
            $salt      = $requestData['pg_salt'];
            $signature = $requestData['pg_sig'];
            $params    = [
                'pg_status' => 'ok',
                'pg_salt'   => $salt,
            ];

            unset($requestData['pg_sig']);

            if ($signature !== $this->getSignature('check', $requestData)) {
                $params['pg_status']            = 'error';
                $params['pg_error_code']        = 100;
                $params['pg_error_description'] = 'incorrect_signature';
            } else {
                if (true === $check($orderId)) {
                    $params['pg_status']  = 'ok';
                    $params['pg_timeout'] = 300;
                } else {
                    $params['pg_status']            = 'error';
                    $params['pg_error_code']        = 340;
                    $params['pg_error_description'] = 'transaction_not_found';
                }
            }

            if ($params['pg_status'] == 'ok') {
                $xmlResponse = [
                    'pg_salt'    => $params['pg_salt'],
                    'pg_status'  => 'ok',
                    'pg_timeout' => $params['pg_timeout'],
                    'pg_sig'     => $this->getSignature('check', $params),
                ];
            } else {
                $xmlResponse = [
                    'pg_salt'              => $params['pg_salt'],
                    'pg_status'            => 'error',
                    'pg_error_code'        => $params['pg_error_code'],
                    'pg_error_description' => $params['pg_error_description'],
                    'pg_sig'               => $this->getSignature('check', $params),
                ];
            }
        }

        return $this->createXmlDocument('response', $xmlResponse);
    }

    /**
     * @param array  $requestData
     * @param string $page
     *
     * @return boolean
     */
    public function success(array $requestData = [], $page = 'success')
    {
        $signature = $requestData['pg_sig'];

        unset($requestData['pg_sig']);

        if (0 === strcmp($this->getSignature($page, $requestData), $signature)) {
            return true;
        }

        return false;
    }

    /**
     * @param array $requestData
     *
     * @return boolean
     */
    public function failure(array $requestData = [])
    {
        return $this->success($requestData, 'failure');
    }
}
