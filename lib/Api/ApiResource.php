<?php

namespace PayBy\Api;

use PayBy\PayBy;
use PayBy\PayByObject;
use PayBy\Util;
use PayBy\Error;

abstract class ApiResource extends PayByObject
{
    private static $HEADERS_TO_PERSIST = ['PayBy-Version' => true];

    public static function baseUrl()
    {
        return PayBy::$apiBase;
    }

    /**
     * @return string The name of the method
     */
    public static function methodName()
    {
        $backtrace = debug_backtrace();
        while ($trace = array_shift($backtrace)) {
            if ($trace["function"] === "_create") {
                return array_shift($backtrace)["function"];
            }
        }
        return "";
    }

    /**
     * @return string The endpoint URL for the given class.
     */
    public static function classUrl()
    {
        $base = static::methodName();
        $apiClass = get_called_class();
        $apiClass = new $apiClass();
        return "/acquire2" . $apiClass->path . "/${base}";
    }

    private static function _validateParams($params = null)
    {
        if ($params && !is_array($params)) {
            $message = "You must pass an array as the first argument to PayBy API "
                . "method calls.";
            throw new Error\Api($message);
        }
    }

    protected static function _staticRequest($method, $url, $params)
    {
        $requestor = new ApiRequestor(static::baseUrl());
        return $requestor->request($method, $url, $params);
    }


    protected static function _create($params = null)
    {
        self::_validateParams($params);
        $url = static::classUrl();

        $response = static::_staticRequest('post', $url, $params);
        return Util\Util::convertToPayByObject($response);
    }

}
