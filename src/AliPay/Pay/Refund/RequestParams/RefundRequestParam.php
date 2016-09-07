<?php
namespace Jueneng\AliPay\Pay\Refund\RequestParams;

use Jueneng\AliPay\BaseRequestParam;
use Jueneng\AliPay\Helper;

class RefundRequestParam extends BaseRequestParam
{
    public function __construct($params, $config, $sign)
    {
        parent::__construct($params, $config, $sign);
    }

    public function init(Array $params)
    {
        $newParams['batch_no'] = $params['batch_no'];
        $newParams['detail_data'] = $this->setAndReturnDetailData($params['trade_no'], $params['price'], $params['reason']);

        $newParams['batch_num'] = '1';
        $newParams['refund_date'] = date('Y-m-d H:i:s');
        $newParams['notify_url'] = $this->config['refund_notify_url'];
        $newParams['service'] = 'refund_fastpay_by_platform_nopwd';

        $newParams = $this->addCommonParams($newParams);

        $newParams['sign'] = $this->sign->createSign(Helper::buildRequestPreStr($newParams), $this->config['private_key_path']);

        $this->params = $newParams;
    }

    public function setAndReturnDetailData($trade_no, $price, $reason)
    {
        return "{$trade_no}^{$price}^{$reason}";
    }

    public function params()
    {
        return Helper::createLinkstringUrlencode($this->params);
    }

    public function getRequestUrl()
    {
        $url = $this->config['alipay_gateway_new']."_input_charset=".trim(strtolower($this->config['input_charset']));

        return $url;
    }
}