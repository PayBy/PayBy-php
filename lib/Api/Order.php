<?php

namespace PayBy\Api;

use PayBy\PayBy;

class Order extends ApiResource
{

    /**
     * @param array|null $params
     *
     * @return Order The created order.
     */
    public static function placeOrder($params = null)
    {
        $wrapper=ApiRequestor::buildPayByPubRequest();
        $wrapper["bizContent"] = $params;
        return self::_create($wrapper);
    }
}
