<?php

namespace Jueneng\AliPay\Pay\Common;

use Jueneng\AliPay\BasePay;
use Jueneng\AliPay\Sign\Md5Sign;
use Jueneng\AliPay\Sign\RSASign;

class CommonPay extends BasePay
{
    public function __construct(array $config=[], $sign=null)
    {
        $sign = new RSASign();
        parent::__construct($config, $sign);

        var_dump($this->config);die;
    }

    /**
     * 退款
     *
     * @param array $params 参数字段名与支付宝接口字段名一样，具体请查看支付宝接口参数文档对应的RefundRequestParam类的init方法
     * @return array|mixed
     */
    public function refund(Array $params)
    {
        $refundRequest = $this->getRequestParam('RefundRequestParam', $params, $this->config, $this->sign);

        $requestResult = $this->executeCurlRequest($refundRequest);

        $requestResult = (array)simplexml_load_string($requestResult, 'SimpleXMLElement', LIBXML_NOCDATA);

        if ($requestResult['is_success'] == 'T') {
            return $this->success('退款成功！', $requestResult);
        }

        return $this->error($this->getErrorMessage('refund', $requestResult['error']), $requestResult);
    }

    public function getRequestParam($requestParamName, $params, $config, $sign)
    {
        $className = '\Jueneng\AliPay\Pay\Common\RequestParams\\'.$requestParamName;

        return new $className($params, $config, $sign);
    }
}