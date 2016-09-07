<?php
return [

    /**
     * 应用ID
     */
    'APP_ID'  => '',

    /**
     * 商户ID
     */
    'MCH_ID' => '',

    /**
     * 用于签名验证的码
     */
    'KEY' => '',
    'APP_SECRET' => '',

    /**
     * 支付请求的URL
     */
    'UNIFIEDORDER_URL' => 'https://api.mch.weixin.qq.com/pay/unifiedorder',

    /**
     * 退款请求的URL
     */
    'REFUND_REQUEST_URL' => 'https://api.mch.weixin.qq.com/secapi/pay/refund',

    /**
     * 支付成功异步通知URL
     */
    'NOTIFY_URL' => '',

    /**
     * 证书地址
     */
    'CERT_PEM_PATH'=> '',   //例如 __DIR__.'/../../src/WeixinPay/cert/Qr/apiclient_cert.pem
    'KEY_PEM_PATH' => '',   //例如__DIR__.'/../../src/WeixinPay/cert/Qr/apiclient_key.pem',
];