<?php

namespace Jueneng\AliPay\Pay\Qr;

use Jueneng\AliPay\BasePay;
use Jueneng\AliPay\Pay\Common\CommonPay;

/**
 * Class QrPay
 */
class QrPay extends BasePay
{
    public function __construct(array $config=[], $sign=null)
    {
        parent::__construct($config, $sign);

        $this->commom = new CommonPay($config);
    }

    public function getRequestParam($requestParamName, $params, $config, $sign)
    {
        $className = '\Jueneng\AliPay\Pay\Qr\RequestParams\\'.$requestParamName;

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

        $result = $this->executeCurlRequest($createOrderRequest);

        $result = json_decode($result, true);

        $sign = isset($result['sign']) ? $result['sign'] : '';
        $response = isset($result['alipay_trade_precreate_response']) ? $result['alipay_trade_precreate_response'] : [];
        if ($response['code'] != '10000') {
            return $this->error($this->getErrorMessage('qrpay', $response['sub_code']), $result);
        }

        $data['sign'] = $sign;
        $data['prestr'] = json_encode($response,  JSON_FORCE_OBJECT | JSON_UNESCAPED_UNICODE);

        if (!$this->sign->verifySign($data, $this->config['ali_rsa_public_key_path'])) {
            return $this->error('无效签名', $result);
        }

        return $this->success('发起支付成功', $response);
    }
}