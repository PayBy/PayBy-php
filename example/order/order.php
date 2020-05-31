<?php
/**
 * PayBy SDK
 * Sample:
 *      Order
 */

require dirname(__FILE__) . '/../../init.php';
require dirname(__FILE__) . '/../config.php';

// placeOrder
$order_no = substr(md5(time()), 0, 20);
try {
	// bizContent
    $or = \PayBy\Api\Order::placeOrder(
        [
            "merchantOrderNo" => $order_no,
            "subject" => "iPhone",
            'totalAmount' => [
	            'currency' => 'AED',
	            'amount' => '0.3',
	        ],
            "paySceneCode" => "DYNQR",
            "notifyUrl" => "http://yoursite.com/api/notification",
            "accessoryContent" => [
	            'amountDetail' => [
	            	'vatAmount' => [
		            	'currency' => 'AED',
		            	'amount' => '0.3',
		            ],
	            ],
	            'goodsDetail' => [
	            	'body' => 'Gifts',
	            	'goodsName' => 'candy flower',
	            	'goodsId' => 'GI1005',
	            ],
	            'terminalDetail' => [
	            	'merchantName' => 'candy home',
	            ],
            ],
        ]
    );
    print_r($or);
} catch (\PayBy\Error\Base $e) {
    // 捕获报错信息
    print_r($e);
}
exit;
