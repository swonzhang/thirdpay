<?php

namespace Jueneng\WeixinPay\Pay\App;


use Jueneng\WeixinPay\BasePay;

class AppPay extends BasePay
{
    public function getRequestParam($requestParamName, $params, $config, $sign)
    {
        $className = '\Jueneng\WeixinPay\Pay\App\RequestParams\\'.$requestParamName;

        return new $className($params, $config, $sign);
    }
}