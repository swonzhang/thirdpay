<?php
return [

    /**
     * 网关，请求地址
     */
    'ALIPAY_GATEWAY_NEW' => 'https://openapi.alipay.com/gateway.do?',

    /**
     * 回调验证URL，https请求
     */
    'HTTPS_VERIFY_URL' => 'https://mapi.alipay.com/gateway.do?service=notify_verify&',

    /**
     * 回调验证URL，http请求
     */
    'HTTP_VERIFY_URL' => 'http://notify.alipay.com/trade/notify_query.do?',

    /**
     * 合作身份者id，以2088开头的16位纯数字
     */
    'PARTNER' => '',

    /**
     * 安全检验码，以数字和字母组成的32位字符，用md5加密签名的时候需要
     */
    'KEY' => '',

    /**
     * 应用ID
     */
    'APP_ID' => '',

    /**
     * 接口版本
     */
    'VERSION' => '1.0',

    /**
     * 请求参数格式
     */
    'FORMAT' => 'json',


    'AUTH_TOKEN' => null,

    /**
     * 卖家支付宝账号
     */
    'SELLER_EMAIL' => '',

    /**
     * 签名方式
     */
    'SIGN_TYPE' => strtoupper('RSA'),

    /**
     * 字符编码格式 目前支持 gbk 或 utf-8
     */
    'INPUT_CHARSET' => strtolower('utf-8'),

    /**
     * ca证书路径地址，用于curl中ssl校验
     */
    'CACERT' => '',     //例如：__DIR__.'/../../src/AliPay/cert/cacert.pem'

    /**
     * 请求协议
     */
    'TRANSPORT' => 'https',

    /**
     * 支付类型,不能修改
     */
    'PAYMENT_TYPE' => '8',

    /**
     * 支付成功服务器异步通知页面路径，需http://格式的完整路径，不能加?id=123这类自定义参数
     */
    'PAY_NOTIFY_URL' => '',

    /**
     * 页面跳转同步通知页面路径，需http://格式的完整路径，不能加?id=123这类自定义参数，不能写成http://localhost/
     */
    'PAY_RETURN_URL' => '',

    /**
     * 应用私钥路径
     */
    'PRIVATE_KEY_PATH' => '',   //例如 __DIR__.'/../../src/AliPay/cert/rsa_private_key.pem'

    /**
     * 支付宝公钥路径
     */
    'ALI_PUBLIC_KEY_PATH' => '',    //例如 __DIR__.'/../../src/AliPay/cert/alipay_public_key.pem'
];