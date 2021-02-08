<?php
return [
    'alipay' => [
        'app_id' => '2016080400168772',
        'ali_public_key' => env('ALIPAY_PUBLIC_KEY', ''),// 支付宝公钥
        'private_key' => env('ALIPAY_PRIVATE_KEY', ''),// 应用私钥
        'log' => [
            'file' => storage_path('logs/alipay.log')
        ],
    ],
    'wechat' => [
        'app_id' => '',
        'mch_id' => '',
        'key' => '',
        'cert_client' => '',
        'cert_key' => '',
        'log' => [
            'file' => storage_path('logs/wechat_pay.log')
        ],
    ],
];
