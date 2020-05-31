<?php

namespace PayBy\Util;

use PayBy\PayByObject;
use stdClass;

abstract class Util
{
    /**
     * Whether the provided array (or other) is a list rather than a dictionary.
     *
     * @param array|mixed $array
     * @return boolean True if the given object is a list.
     */
    public static function isList($array)
    {
        if (!is_array($array)) {
            return false;
        }

        // TODO: generally incorrect, but it's correct given PayBy's response
        foreach (array_keys($array) as $k) {
            if (!is_numeric($k)) {
                return false;
            }
        }
        return true;
    }

    /**
     * Recursively converts the PHP PayBy object to an array.
     *
     * @param array $values The PHP PayBy object to convert.
     * @param bool
     * @return array
     */
    public static function convertPayByObjectToArray($values, $keep_object = false)
    {
        $results = [];
        foreach ($values as $k => $v) {
            // FIXME: this is an encapsulation violation
            if ($k[0] == '_') {
                continue;
            }
            if ($v instanceof PayByObject) {
                $results[$k] = $keep_object ? $v->__toStdObject(true) : $v->__toArray(true);
            } elseif (is_array($v)) {
                $results[$k] = self::convertPayByObjectToArray($v, $keep_object);
            } else {
                $results[$k] = $v;
            }
        }
        return $results;
    }

    /**
     * Recursively converts the PHP PayBy object to an stdObject.
     *
     * @param array $values The PHP PayBy object to convert.
     * @return array
     */
    public static function convertPayByObjectToStdObject($values)
    {
        $results = new stdClass;
        foreach ($values as $k => $v) {
            // FIXME: this is an encapsulation violation
            if ($k[0] == '_') {
                continue;
            }
            if ($v instanceof PayByObject) {
                $results->$k = $v->__toStdObject(true);
            } elseif (is_array($v)) {
                $results->$k = self::convertPayByObjectToArray($v, true);
            } else {
                $results->$k = $v;
            }
        }
        return $results;
    }

    /**
     * Converts a response from the PayBy API to the corresponding PHP object.
     *
     * @param stdObject $resp The response from the PayBy API.
     * @return PayByObject|array
     */
    public static function convertToPayByObject($resp)
    {
        $types = [
            'agreement' => \PayBy\Agreement::class,
            'balance_bonus' => \PayBy\BalanceBonus::class,
            'balance_settlement' => \PayBy\BalanceSettlements::class,
            'balance_transaction' => \PayBy\BalanceTransaction::class,
            'balance_transfer' => \PayBy\BalanceTransfer::class,
            'batch_refund' => \PayBy\BatchRefund::class,
            'batch_transfer' => \PayBy\BatchTransfer::class,
            'batch_withdrawal' => \PayBy\BatchWithdrawal::class,
            'channel' => \PayBy\Channel::class,
            'charge' => \PayBy\Charge::class,
            'coupon' => \PayBy\Coupon::class,
            'coupon_template' => \PayBy\CouponTemplate::class,
            'customs' => \PayBy\Customs::class,
            'event' => \PayBy\Event::class,
            'list' => \PayBy\Collection::class,
            'order' => \PayBy\Order::class,
            'profit_transaction' => \PayBy\ProfitTransaction::class,
            'recharge' => \PayBy\Recharge::class,
            'red_envelope' => \PayBy\RedEnvelope::class,
            'refund' => \PayBy\Refund::class,
            'royalty' => \PayBy\Royalty::class,
            'royalty_settlement' => \PayBy\RoyaltySettlement::class,
            'royalty_template' => \PayBy\RoyaltyTemplate::class,
            'royalty_transaction' => \PayBy\RoyaltyTransaction::class,
            'settle_account' => \PayBy\SettleAccount::class,
            'split_profit' => \PayBy\SplitProfit::class,
            'split_receiver' => \PayBy\SplitReceiver::class,
            'sub_app' => \PayBy\SubApp::class,
            'sub_bank' => \PayBy\SubBank::class,
            'transfer' => \PayBy\Transfer::class,
            'user' => \PayBy\User::class,
            'withdrawal' => \PayBy\Withdrawal::class,
        ];
        if (self::isList($resp)) {
            $mapped = [];
            foreach ($resp as $i) {
                array_push($mapped, self::convertToPayByObject($i));
            }
            return $mapped;
        } elseif (is_object($resp)) {
            if (isset($resp->object)
                && is_string($resp->object)
                && isset($types[$resp->object])) {
                    $class = $types[$resp->object];
            } else {
                $class = 'PayBy\\PayByObject';
            }
            return $class::constructFrom($resp);
        } else {
            return $resp;
        }
    }

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
