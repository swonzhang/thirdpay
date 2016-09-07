<?php

namespace Jueneng\WeixinPay\Pay\Qr;

use Jueneng\WeixinPay\BasePay;

class QrPay extends BasePay
{
    public function getRequestParam($requestParamName, $params, $config, $sign)
    {
        $className = '\Jueneng\WeixinPay\Pay\Qr\RequestParams\\'.$requestParamName;

        return new $className($params, $config, $sign);
    }
}