<?php

namespace Jueneng\WeixinPay;

use Jueneng\Interfaces\SignInterface;

abstract class BaseRequestParam
{
    protected $config;      //配置选项

    protected $params;      //请求参数数组

    protected $now;         //当前时间

    protected $sign;        //签名处理器对象

    public function __construct(Array $params, Array $config, SignInterface $sign)
    {
        $this->config = $config;

        $this->now = time();

        $this->sign = $sign;

        $this->init($params);
    }

    /**
     * 获取请求URL
     *
     * @return mixed
     */
    public function getRequestUrl()
    {
        return $this->config['unifiedorder_url'];
    }

    /**
     * 获取请求的参数
     *
     * @return string
     */
    public function params()
    {
        return Helper::toXml($this->params);
    }

    /**
     * 初始化请求参数
     *
     * @param array $params
     * @return mixed
     */
    abstract public function init(Array $params);
}