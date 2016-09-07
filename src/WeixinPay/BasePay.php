<?php

namespace Jueneng\WeixinPay;

use Jueneng\Interfaces\PayInterface;
use Jueneng\WeixinPay\Sign\Md5Sign;

/**
 * 微信支付相关处理基类
 */
abstract class BasePay implements PayInterface
{
    protected $config;      //配置选项

    protected $request;     //请求处理器对象

    protected $now;         //当前时间

    protected $sign;        //签名处理器对象

    public function __construct($config=[], $sign=null)
    {
        $this->config = array_change_key_case($config, CASE_LOWER);
        $this->request = new Request();
        $this->now = time();
        $this->sign = is_null($sign) ? new Md5Sign() : $sign;
    }

    /**
     * 设置配置
     *
     * @param $config
     */
    public function setConfig($config)
    {
        $this->config = array_change_key_case($config, CASE_LOWER);
    }

    /**
     * 统一发起支付
     *
     * @param array $params 参数字段名与微信接口字段名一样，具体请查看微信接口参数文档以及对应的CreateOrderRequestParam类的init方法
     * @return array
     */
    public function createOrder(Array $params)
    {
        $createOrderRequest = $this->getRequestParam('CreateOrderRequestParam', $params, $this->config, $this->sign);

        $result = $this->executeRequest($createOrderRequest);

        if ($result['return_code'] != "SUCCESS") {
            return $this->error($result['return_msg'], $result);
        }
        if (!$this->sign->verifySign($result, $this->config['key'])) {
            return $this->error("验证微信的签名失败", $result);
        }
        if ($result['result_code'] != 'SUCCESS') {
            $message = "err_code＝{$result['err_code']}, err_code_des＝{$result['err_code_des']}";
            return $this->error($message, $result);
        }

        return $this->responseCreateOrder($result);
    }

    /**
     * 返回发起支付结果
     *
     * @param $result
     * @return array
     */
    protected function responseCreateOrder($result)
    {
        return $this->success('发起支付成功', $result);
    }

    /**
     * 退款
     *
     * @param array $params 参数字段名与微信接口字段名一样，具体请查看微信接口参数文档以及对应的RefundRequestParam类的init方法
     * @return array
     */
    public function refund(Array $params)
    {
        $refundRequest = $this->getRequestParam('RefundRequestParam', $params, $this->config, $this->sign);

        //发起请求
        $result = $this->executeRequestWithPem($refundRequest, $this->config['cert_pem_path'], $this->config['key_pem_path']);

        if ($result['return_code'] != "SUCCESS") {
            return $this->error($result['return_msg'], $result);
        }
        if (!$this->sign->verifySign($result, $this->config['key'])) {
            return $this->error("验证微信的签名失败", $result);
        }

        if ($result['result_code'] != 'SUCCESS') {
            $message = "err_code＝{$result['err_code']}, err_code_des＝{$result['err_code_des']}";
            return $this->error($message, $result);
        }

        return $this->success('退款成功');
    }

    /**
     * 执行请求
     *
     * @param $request
     * @return array|mixed
     */
    protected function executeRequest($request)
    {
        // 请求微信服务器
        $result = $this->request->curlPost($request->getRequestUrl(), $request->params());

        $result = (array)simplexml_load_string($result, 'SimpleXMLElement', LIBXML_NOCDATA);

        return $result;
    }

    /**
     * 执行带证书的请求
     *
     * @param $request
     * @param $certPemPath
     * @param $keyPemPath
     * @return array|mixed
     */
    protected function executeRequestWithPem($request, $certPemPath, $keyPemPath)
    {
        // 请求微信服务器
        $result = $this->request->curlPostWithCert($request->getRequestUrl(), $request->params(), $certPemPath, $keyPemPath);

        $result = (array)simplexml_load_string($result, 'SimpleXMLElement', LIBXML_NOCDATA);

        return $result;
    }

    /**
     * 验证返回数据签名
     *
     * @param $contents
     * @return array|bool
     */
    public function verifyReturn($contents)
    {
        $contents = Helper::decodeUnicode($contents);
        // 解析字符串
        $result = (array)simplexml_load_string($contents, 'SimpleXMLElement', LIBXML_NOCDATA);
        if (!$this->sign->verifySign($result, $this->config['key'])) {
            return false;
        }

        return $result;
    }

    /**
     * 成功返回
     *
     * @param $message
     * @param array $data
     * @return array
     */
    public function success($message, $data=[])
    {
        return array("success"=>true, "message"=>$message, 'data'=>$data);
    }

    /**
     * 错误返回
     *
     * @param $message
     * @param array $data
     * @return array
     */
    public function error($message, $data=[])
    {
        return array("success"=>false, "message"=>$message, 'data'=>$data);
    }

    /**
     * 异步通知处理失败后，返回给微信
     */
    public function responseNotifyFailed()
    {
        echo 'error';
        return;
    }

    /**
     * 异步通知处理成功后，返回给微信，微信收到该字符串，就不会再次通知支付结果。
     */
    public function responseNotifySuccess()
    {
        $str = "<xml>
           <return_code><![CDATA[SUCCESS]]></return_code>
           <return_msg><![CDATA[OK]]></return_msg>
        </xml>";

        echo $str;

        return;
    }
}