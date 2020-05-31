# PayBy PHP SDK

## Introduce

payby.com

## Env

PHP >= 5.6

## Installation

### By Composer

```
composer require payby/payby-php
```

### Composer autoload import

```php
require_once('vendor/autoload.php');
```

### Manual import

```php
require_once('/path/to/payby-php/init.php');
```

## Api

### Initial

```php
\PayBy\PayBy::setPrivateKey('YOUR-KEY');
```

## Order
### Create an order
```php
\PayBy\Api\Order::placeOrder(
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
```
### cancelOrder
```php
\PayBy\Api\Order::placeOrder();
```
### getOrder
```php
\PayBy\Api\Order::getOrder();
```

## Refund
### placeOrder
```php
\PayBy\Api\Refund::placeOrder();
```
### getOrder
```php
\PayBy\Api\Refund::getOrder();
```

## Transfer
### placeTransferOrder
```php
\PayBy\Api\Transfer::placeTransferOrder();
```
### getTransferOrder
```php
\PayBy\Api\Transfer::getTransferOrder();
```
### placeTransferToBankOrder
```php
\PayBy\Api\Transfer::placeTransferToBankOrder();
```
### getTransferToBankOrder
```php
\PayBy\Api\Transfer::getTransferToBankOrder();
```

## Result notification
### Verify signature
```php
// TODO
```