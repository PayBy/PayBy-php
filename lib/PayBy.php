<?php

namespace PayBy;

class PayBy
{
    /**
     * @var string The PayBy app ID to be used for users/coupons/balances/...
     */
    public static $partnerId = null;
    /**
     * @var string The base URL for the PayBy API.
     */
    public static $apiBase = 'https://api.payby.com/sgs/api';
    /**
     * @var string|null The version of the PayBy API to use for requests.
     */
    public static $apiVersion = null;
    /**
     * @var boolean Defaults to true.
     */
    public static $verifySslCerts = true;

    const VERSION = '0.0.9';

    /**
     * @var string The public key to be used for signing requests.
     */
    public static $publicKey;

    /**
     * @var string The PEM formatted private key to be used for signing requests.
     */
    public static $privateKey;

    /**
     * @var string The path to the private key that will be used to sign requests.
     */
    public static $privateKeyPath;

    /**
     * @var string The CA certificate path.
     */
    public static $caBundle;

    /**
     * @return string The app ID used for requests.
     */
    public static function getPartnerId()
    {
        return self::$partnerId;
    }

    /**
     * Sets the app ID to be used for requests.
     *
     * @param string $partnerId
     */
    public static function setPartnerId($partnerId)
    {
        self::$partnerId = $partnerId;
    }

    /**
     * @return string The API version used for requests. null if we're using the
     *    latest version.
     */
    public static function getApiVersion()
    {
        return self::$apiVersion;
    }

    /**
     * @param string $apiVersion The API version to use for requests.
     */
    public static function setApiVersion($apiVersion)
    {
        self::$apiVersion = $apiVersion;
    }

    /**
     * @return boolean
     */
    public static function getVerifySslCerts()
    {
        return self::$verifySslCerts;
    }

    /**
     * @param boolean $verify
     */
    public static function setVerifySslCerts($verify)
    {
        self::$verifySslCerts = $verify;
    }

    /**
     * @return string
     */
    public static function getPrivateKey()
    {
        return self::$privateKey;
    }

    /**
     * @param string $key
     */
    public static function setPrivateKey($key)
    {
        self::$privateKey = $key;
    }

    /**
     * @param string $apiBase
     */
    public static function setApiBase($apiBase)
    {
        self::$apiBase = $apiBase;
    }

    /**
     * @return string
     */
    public static function getPrivateKeyPath()
    {
        return self::$privateKeyPath;
    }

    /**
     * @param string $path
     */
    public static function setPrivateKeyPath($path)
    {
        self::$privateKeyPath = $path;
    }
}
