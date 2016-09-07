<?php
namespace Jueneng\AliPay\Pay\Direct\RequestParams;

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
        $newParams['out_trade_no'] = $params['out_trade_no'];
        $newParams['total_fee'] = $params['total_fee'];
        $newParams['subject'] = $params['subject'];
        $newParams['body'] = $params['body'];
        $newParams['extra_common_param'] = $params['extra_common_param'];

        $newParams['show_url'] = $this->config['pay_show_url'];
        $newParams['return_url'] = $this->config['pay_return_url'];
        $newParams['notify_url'] = $this->config['pay_notify_url'];
        $newParams['payment_type'] = $this->config['payment_type'];
        $newParams['service'] = 'create_direct_pay_by_user';

        $newParams = $this->addCommonParams($newParams);

        $newParams['sign'] = $this->sign->createSign(Helper::buildRequestPreStr($newParams), $this->config['key']);

        $this->params = $newParams;
    }
}