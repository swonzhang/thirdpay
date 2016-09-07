<?php

namespace Jueneng\WeixinPay\Pay\App\RequestParams;

use Jueneng\Interfaces\SignInterface;
use Jueneng\WeixinPay\BaseRequestParam;

class CreateOrderRequestParam extends BaseRequestParam
{
    public function __construct(Array $params, Array $config, SignInterface $sign)
    {
        parent::__construct($params, $config, $sign);
    }

    public function init(Array $params)
    {
        /**
         * 必填参数
         */
        $newParams['out_trade_no'] = $params['out_trade_no'];
        $newParams['body'] = $params['body'];
        $newParams['total_fee'] = $params['total_fee'];
        /**
         * 选填参数
         */
        if (isset($params['device_info'])) {
            $newParams['device_info'] = $params['device_info'];
        }
        if (isset($params['detail'])) {
            $newParams['detail'] = $params['detail'];
        }
        if (isset($params['attach'])) {
            $newParams['attach'] = $params['attach'];
        }
        if (isset($params['fee_type'])) {
            $newParams['fee_type'] = $params['fee_type'];
        }
        if (isset($params['time_start'])) {
            $newParams['time_start'] = $params['time_start'];
        }
        if (isset($params['time_expire'])) {
            $newParams['time_expire'] = $params['time_expire'];
        }
        if (isset($params['goods_tag'])) {
            $newParams['goods_tag'] = $params['goods_tag'];
        }
        if (isset($params['product_id'])) {
            $newParams['product_id'] = $params['product_id'];
        }
        if (isset($params['limit_pay'])) {
            $newParams['limit_pay'] = $params['limit_pay'];
        }
        if (isset($params['openid'])) {
            $newParams['openid'] = $params['openid'];
        }
        /**
         * 系统参数
         */
        $newParams['spbill_create_ip'] = '192.168.1.1';
        $newParams['notify_url'] = $this->config['notify_url'];
        $newParams['trade_type'] = 'APP';
        $newParams['appid'] = $this->config['app_id'];
        $newParams['mch_id'] = $this->config['mch_id'];
        $newParams['nonce_str'] = md5($this->now);
        $newParams['sign'] = $this->sign->getSignText($newParams, $this->config['key']);

        $this->params = $newParams;
    }
}