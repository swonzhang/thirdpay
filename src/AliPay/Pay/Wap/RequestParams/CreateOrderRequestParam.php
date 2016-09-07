<?php
namespace Jueneng\AliPay\Pay\Wap\RequestParams;

use Jueneng\AliPay\BaseRequestParam;
use Jueneng\AliPay\Helper;

class CreateOrderRequestParam extends BaseRequestParam
{
    public function __construct($params, $config, $sign)
    {
        parent::__construct($params, $config, $sign);
    }

    public function init(Array $params)
    {
        $params['seller_id'] = $this->config['partner'];
        $params['timeout_express'] = '2h';
        $params['product_code'] = 'QUICK_WAP_PAY';
        $bizContent = Helper::convertToBizContentFormat($params);
        $newParams['biz_content'] = $bizContent;

        $newParams = $this->addNewCommonParams($newParams);
        $newParams['timestamp'] = date("Y-m-d H:i:s", $this->now);
        $newParams['method'] = 'alipay.trade.wap.pay';
        $newParams['notify_url'] = $this->config['pay_notify_url'];
        $newParams['return_url'] = $this->config['pay_return_url'];

        $newParams['sign'] = $this->sign->createSign(Helper::buildRequestPreStr($newParams, true), $this->config['private_key_path']);

        $this->params = $newParams;
    }

    public function params()
    {
        return $this->params;
    }

    public function getRequestUrl()
    {
        return $this->config['alipay_gateway_new'].'charset='.trim(strtolower($this->config['input_charset']));
    }
}