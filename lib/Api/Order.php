<?php

namespace PayBy\Api;

use PayBy\PayBy;

class Order extends ApiResource
{

    /**
     * @param array|null $params
     * @param array|string|null $opts
     *
     * @return Order The created order.
     */
    public static function placeOrder($params = null, $opts = null)
    {
        return self::_create($params, $opts);
    }
}
