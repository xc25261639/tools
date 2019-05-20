<?php
require_once __DIR__ . '/../vendor/autoload.php';

use tools\Pay;
$public_key = openssl_pkey_get_public(file_get_contents(dirname(__FILE__).'/sxf_public_key.pem'));
$private_key = openssl_pkey_get_private(file_get_contents(dirname(__FILE__).'/rsa_private_key.pem'));
$config = [
		'private_key' => $private_key,
		'public_key' => $public_key,
		'partner' => '120711076',
        'notify_url' => 'http://xxx.com/notify.php',
        'return_url' => 'http://xxx.com/return.php',
        'mode' => 'dev',
        'aes_key' => 'mil1fjndiuryhjw6evi0qba2ls93cip3',
	];
$data = ['out_trade_no' => '20180507101519898101',
			'subject' => '大苹果',
			'total_fee' => 0.1,
		];
$pay = new Pay($config);
$res = $pay->get_token($data);
var_dump($res);die;