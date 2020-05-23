<?php

// payby partner id
const PARTNER_ID = '200000000001';

\PayBy\PayBy::setParterId(PARTNER_ID); // 设置 App ID

\PayBy\PayBy::setPrivateKey(file_get_contents(__DIR__ . '/PayBy_key_private.pem'));
\PayBy\PayBy::setPublicKey(file_get_contents(__DIR__ . '/PayBy_key_public_key.pem'));
