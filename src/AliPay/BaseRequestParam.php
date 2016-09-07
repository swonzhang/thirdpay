<?php

namespace Jueneng\AliPay;


abstract class BaseRequestParam
{
    protected $config;

    protected $params;

    protected $now;

    protected $sign;

    protected $bizContent;

    public function __construct($params, $config, $sign)
    {
        $this->config = $config;

        $this->now = time();

        $this->sign = $sign;

        $this->init($params);
    }

    public function addCommonParams(Array $params)
    {
        $params['sign_type'] = $this->config['sign_type'];
        $params['partner'] = $this->config['partner'];
        $params['seller_id'] = $this->config['partner'];
        $params['_input_charset'] = trim(strtolower($this->config['input_charset']));

        return $params;
    }

    public function addNewCommonParams(Array $params)
    {
        $params['app_id'] = $this->config['app_id'];
        $params['format'] = $this->config['format'];
        $params['charset'] = $this->config['input_charset'];
        $params['sign_type'] = $this->config['sign_type'];
        $params['timestamp'] = date('Y-m-d H:i:s', $this->now);
        $params['version'] = $this->config['version'];
        $params['auth_token'] = $this->config['auth_token'];

        return $params;
    }

    public function getRequestUrl()
    {
        return $this->config['alipay_gateway_new'].'input_charset='.trim(strtolower($this->config['input_charset']));
    }

    public function params()
    {
        return $this->params;
    }

    abstract public function init(Array $params);
}