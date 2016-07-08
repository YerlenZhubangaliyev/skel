<?php
namespace App\Vendor\Payment\Epay;

/**
 *
 */
class Signer
{

    /**
     * @var
     */
    public $privateKey;

    /**
     * @var boolean
     */
    public $invert;

    /**
     * Signer constructor.
     */
    public function __construct()
    {
        $this->invert = true;
    }

    /**
     * @param $keyPath
     * @param $password
     *
     * @return $this
     */
    public function setPrivateKey($keyPath, $password)
    {
        $privateKeyRaw = file_get_contents($keyPath);
        $privateKey    = null;

        if ($privateKeyRaw) {
            $privateKey = \openssl_get_privatekey($privateKeyRaw, $password);
        }

        if (null !== $privateKey && \is_resource($privateKey)) {
            $this->privateKey = $privateKey;
        }

        return $this;
    }

    /**
     * @param  string $string
     *
     * @return string
     */
    public function reverse($string)
    {
        return \strrev($string);
    }

    /**
     * @param  string $stringToSign
     *
     * @return boolean|string
     */
    public function sign($stringToSign)
    {
        $signResult = "";

        if (\is_resource($this->privateKey)) {
            if (\openssl_sign($stringToSign, $signResult, $this->privateKey)) {
                if (true === $this->invert) {
                    $signResult = $this->reverse($signResult);
                }

                return $signResult;
            }
        }

        return false;
    }

    /**
     * @param $data
     * @param $string
     * @param $keyPath
     *
     * @return integer|string
     */
    public function checkSign($data, $string, $keyPath)
    {
        $publicKeyRaw = file_get_contents($keyPath);
        $publicKeyId  = \openssl_pkey_get_public($publicKeyRaw);

        if (true === $this->invert) {
            $string = $this->reverse($string);
        }

        if (\is_resource($publicKeyId)) {
            $result = \openssl_verify($data, $string, $publicKeyId);
            openssl_free_key($publicKeyId);

            return $result;
        } else {
            return openssl_error_string();
        }
    }

    /**
     * @param $response
     *
     * @return mixed
     */
    public function getDataToValidate($response)
    {
        if (preg_match("/<document>(.+)<bank_sign.*\\z/", $response, $matches)) {
            return $matches[1];
        }
    }

    /**
     * @param $response
     * @param $bankPublicKey
     *
     * @return boolean|integer|string
     */
    public function checkBankSign($response, $bankPublicKey)
    {
        $xml           = new \SimpleXMLElement($response);
        $bank          = $xml->xpath('//bank_sign');
        $bankSignature = (string)$bank[0];

        if ($bankSignature) {
            return $this->checkSign($this->getDataToValidate($response), base64_decode($bankSignature), $bankPublicKey);
        }

        return false;
    }
}
