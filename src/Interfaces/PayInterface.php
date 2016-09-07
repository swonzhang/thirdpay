<?php
namespace Jueneng\Interfaces;


interface PayInterface
{
    /**
     * 发起支付
     *
     * @param array $params
     * @return mixed
     */
    public function createOrder(Array $params);

    /**
     * 退款
     *
     * @param array $params
     * @return mixed
     */
    public function refund(Array $params);

    /**
     * 返回数据验证
     *
     * @param $params
     * @return mixed
     */
    public function verifyReturn($params);

    /**
     * 成功返回数组
     *
     * @param $message
     * @param array $data
     * @return mixed
     */
    public function success($message, $data=[]);

    /**
     * 失败返回数组
     *
     * @param $message
     * @param array $data
     * @return mixed
     */
    public function error($message, $data=[]);

    /**
     * 设置配置
     *
     * @param $config
     * @return mixed
     */
    public function setConfig($config);

    /**
     * 实例化请求参数对象
     *
     * @param $requestParamName
     * @param $params
     * @param $config
     * @param $sign
     * @return mixed
     */
    public function getRequestParam($requestParamName, $params, $config, $sign);

    /**
     * 异步通知处理成功后返回
     *
     * @return mixed
     */
    public function responseNotifySuccess();

    /**
     * 异步通知处理失败后返回
     *
     * @return mixed
     */
    public function responseNotifyFailed();


}