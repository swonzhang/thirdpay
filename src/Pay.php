<?php

namespace Jueneng;

class Pay
{
    private static $map = [
        'alipay' => [
            'direct' => 'Jueneng\AliPay\Pay\Direct\DirectPay',
            'refund' => 'Jueneng\AliPay\Pay\Refund\Refund',
            'app' => 'Jueneng\AliPay\Pay\App\AppPay',
            'qr' => 'Jueneng\AliPay\Pay\Qr\QrPay',
            'wap' => 'Jueneng\AliPay\Pay\Wap\WapPay',
        ],
        'weixinpay' => [
            'app'=> 'Jueneng\WeixinPay\Pay\App\AppPay',
            'js'=> 'Jueneng\WeixinPay\Pay\Js\JsPay',
            'qr'=> 'Jueneng\WeixinPay\Pay\Qr\QrPay',
        ]
    ];

    private static $instance;       //支付对象

    /**
     * 使用单例模式实例化支付对象
     *
     * @param $name
     * @return mixed
     */
    public static function getInstance($name)
    {
        if (is_null(self::$instance)) {
            $arr = explode('.', $name);
            $company = $arr[0];
            $type = $arr[1];
            $className = self::$map[$company][$type];
            self::$instance = new $className;
        }

        return self::$instance;
    }
}