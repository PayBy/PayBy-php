<?php

// payby partner id
const PARTNER_ID = '200000000001';

\PayBy\PayBy::$caBundle=__DIR__ . '/cert/cacert.pem';
\PayBy\PayBy::setPartnerId(PARTNER_ID);

\PayBy\PayBy::setPrivateKey(file_get_contents(__DIR__ . '/cert/PayBy_key_private.pem'));
\PayBy\PayBy::setApiBase('https://api.payby.com/sgs/api');