<?php

namespace PayBy\Api;

use PayBy\PayBy;

class Refund extends ApiResource
{
    public $path = "/refund";

    /**
     * @param array|null $params
     *
     * @return Order The created order.
     */
    public static function placeOrder($params = null)
    {
        $wrapper = ApiRequestor::buildPayByPubRequest();
        $wrapper["bizContent"] = $params;
        return self::_create($wrapper);
    }

    /**
     * @param array|null $params
     *
     * @return Response getOrder response.
     */
    public static function getOrder($params = null)
    {
        $wrapper=ApiRequestor::buildPayByPubRequest();
        $wrapper["bizContent"] = $params;
        return self::_create($wrapper);
    }
}