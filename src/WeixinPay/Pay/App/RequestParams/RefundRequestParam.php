<?php

namespace Jueneng\WeixinPay\Pay\App\RequestParams;

use Jueneng\Interfaces\SignInterface;
use Jueneng\WeixinPay\BaseRequestParam;

class RefundRequestParam extends BaseRequestParam
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
        $newParams['refund_fee'] = $params['refund_fee'];
        $newParams['total_fee'] = $params['total_fee'];
        $newParams['out_refund_no'] = $params['out_refund_no'];
        /**
         * 选填参数
         */
        if (isset($params['device_info'])) {
            $newParams['device_info'] = $params['device_info'];
        }
        if (isset($params['refund_fee_type'])) {
            $newParams['refund_fee_type'] = $params['refund_fee_type'];
        }
        /**
         * 系统参数
         */
        $newParams['op_user_id'] = $this->config['mch_id'];
        $newParams['appid'] = $this->config['app_id'];
        $newParams['mch_id'] = $this->config['mch_id'];
        $newParams['nonce_str'] = md5($this->now);
        $newParams['sign'] = $this->sign->getSignText($newParams, $this->config['key']);

        $this->params = $newParams;
    }
}