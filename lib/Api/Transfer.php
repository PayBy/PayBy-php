<?php

namespace PayBy\Api;

use PayBy\PayBy;

class Transfer extends ApiResource
{
    public $path = "/transfer";

    /**
     * @param array|null $params
     *
     * @return Order The created order.
     */
    public static function placeTransferOrder($params = null)
    {
        $wrapper = ApiRequestor::buildPayByPubRequest();
        $wrapper["bizContent"] = $params;
        return self::_create($wrapper);
    }

    /**
     * @param array|null $params
     *
     * @return Response getTransferOrder response.
     */
    public static function getTransferOrder($params = null)
    {
        $wrapper=ApiRequestor::buildPayByPubRequest();
        $wrapper["bizContent"] = $params;
        return self::_create($wrapper);
    }
    /**
     * @param array|null $params
     *
     * @return Response placeTransferToBankOrder response.
     */
    public static function placeTransferToBankOrder($params = null)
    {
        $wrapper=ApiRequestor::buildPayByPubRequest();
        $wrapper["bizContent"] = $params;
        return self::_create($wrapper);
    }
    /**
     * @param array|null $params
     *
     * @return Response getTransferToBankOrder response.
     */
    public static function getTransferToBankOrder($params = null)
    {
        $wrapper=ApiRequestor::buildPayByPubRequest();
        $wrapper["bizContent"] = $params;
        return self::_create($wrapper);
    }
}