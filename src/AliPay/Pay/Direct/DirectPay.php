<?php

namespace Jueneng\AliPay\Pay\Direct;

use Jueneng\AliPay\BasePay;
use Jueneng\AliPay\Sign\Md5Sign;

class DirectPay extends BasePay
{
    protected $signKeyConfigName = 'key';

    public function __construct(array $config=[], $sign=null)
    {
        $sign = new Md5Sign();
        parent::__construct($config, $sign);
    }

    public function getRequestParam($requestParamName, $params, $config, $sign)
    {
        $className = '\Jueneng\AliPay\Pay\Direct\RequestParams\\'.$requestParamName;

        return new $className($params, $config, $sign);
    }

    /**
     * 发起支付
     *
     * @param array $params 参数字段名与支付宝接口字段名一样，具体请查看支付宝接口参数文档对应的CreateOrderRequestParam类的init方法
     * @return mixed
     */
    public function createOrder(Array $params)
    {
        $createOrderRequest = $this->getRequestParam('CreateOrderRequestParam', $params, $this->config, $this->sign);

        $html = $this->executeFormRequest($createOrderRequest);

        echo $html;
    }
}