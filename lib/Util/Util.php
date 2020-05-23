<?php

namespace PayBy\Util;

use PayBy\PayByObject;
use stdClass;

abstract class Util
{

    /**
     * Get the request headers
     * @return array An hash map of request headers.
     */
    public static function getRequestHeaders()
    {
        if (function_exists('getallheaders')) {
            $headers = [];
            foreach (getallheaders() as $name => $value) {
                $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('-', ' ', $name))))] = $value;
            }
            return $headers;
        }
        $headers = [];
        foreach ($_SERVER as $name => $value) {
            if (substr($name, 0, 5) == 'HTTP_') {
                $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
            }
        }
        return $headers;
    }

    /**
     * @param string|mixed $value A string to UTF8-encode.
     *
     * @return string|mixed The UTF8-encoded string, or the object passed in if
     *    it wasn't a string.
     */
    public static function utf8($value)
    {
        if (is_string($value)
            && mb_detect_encoding($value, "UTF-8", true) != "UTF-8"
        ) {
            return utf8_encode($value);
        } else {
            return $value;
        }
    }
}
