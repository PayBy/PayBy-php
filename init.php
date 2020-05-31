<?php

if (!function_exists('curl_init')) {
    throw new Exception('PayBy needs the CURL PHP extension.');
}
if (!function_exists('json_decode')) {
    throw new Exception('PayBy needs the JSON PHP extension.');
}
if (!function_exists('mb_detect_encoding')) {
    throw new Exception('PayBy needs the Multibyte String PHP extension.');
}

// PayBy
require(dirname(__FILE__) . '/lib/PayBy.php');

// Utilities
require(dirname(__FILE__) . '/lib/Util/Util.php');
require(dirname(__FILE__) . '/lib/Util/Set.php');

// Errors
require(dirname(__FILE__) . '/lib/Error/Base.php');
require(dirname(__FILE__) . '/lib/Error/Api.php');
require(dirname(__FILE__) . '/lib/Error/ApiConnection.php');
require(dirname(__FILE__) . '/lib/Error/Authentication.php');
require(dirname(__FILE__) . '/lib/Error/InvalidRequest.php');

require(dirname(__FILE__) . '/lib/PayByObject.php');

// Api Base
require(dirname(__FILE__) . '/lib/Api/ApiRequestor.php');
require(dirname(__FILE__) . '/lib/Api/ApiResource.php');

// PayBy API Resources
require(dirname(__FILE__) . '/lib/Api/Order.php');