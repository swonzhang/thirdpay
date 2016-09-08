<?php

namespace Jueneng\AliPay;

use Jueneng\AliPay\Sign\RSASign;
use Jueneng\Interfaces\PayInterface;

abstract class BasePay implements PayInterface
{
    protected $config;

    protected $request;

    protected $sign;

    protected $now;

    protected $allErrorCode;

    protected $signKeyConfigName = 'ali_public_key_path';

    protected $commom = null;

    public function __construct($config=[], $sign=null)
    {
        $this->config = array_change_key_case($config, CASE_LOWER);

        $this->request = new Request();

        $this->sign = is_null($sign) ? new RSASign() : $sign;

        $this->allErrorCode =  include_once __DIR__.'/error_code.php';

        $this->now = time();
    }

    public function setConfig($config)
    {
        $this->config = array_change_key_case($config, CASE_LOWER);

        if (!is_null($this->commom)) {
            $this->commom->setConfig($this->config);
        }
    }

    public function createOrder(Array $params)
    {
        return false;
    }

    public function refund(Array $params)
    {
        return $this->commom->refund($params);
    }

    /**
     * curl请求
     *
     * @param $para_temp
     * @return mixed
     */
    public function executeCurlRequest($request)
    {
        $result = $this->request->cPost($request->getRequestUrl(), $this->config['cacert'], $request->params(), $this->getCharset());

        return $result;
    }

    public function executeFormRequest($request, $method='POST')
    {
        $result = $this->request->formPost($request->getRequestUrl(), $request->params(), $method, $this->getCharset());

        return $result;
    }

    /**
     * 针对return_url验证消息是否是支付宝发出的合法消息
     *
     * @param $request
     * @return bool
     */
    public function verifyReturn($request)
    {
        if(empty($request)) {//判断POST来的数组是否为空
            return false;
        }

        //生成签名结果
        $data['prestr'] = Helper::buildRequestPreStr($request);
        $data['sign'] = $request['sign'];
        $isSign = $this->sign->verifySign($data, trim($this->config[$this->signKeyConfigName]));
        //获取支付宝远程服务器ATN结果（验证是否是支付宝发来的消息）
        $responseTxt = 'false';
        if (! empty($request["notify_id"])) {
            $responseTxt = $this->getResponse($request["notify_id"]);
        }

        if (preg_match("/true$/i",$responseTxt) and $isSign) {
            return true;
        }

        return false;

    }

    /**
     * 获取远程服务器ATN结果,验证返回URL
     *
     * @param $notify_id 通知校验ID
     * @return 服务器ATN结果
     * 验证结果集：
     * invalid命令参数不对 出现这个错误，请检测返回处理中partner和key是否为空
     * true 返回正确信息
     * false 请检查防火墙或者是服务器阻止端口问题以及验证时间是否超过一分钟
     */
    private function getResponse($notify_id)
    {
        $transport = strtolower(trim($this->config['transport']));
        $partner = trim($this->config['partner']);

        if($transport == 'https') {
            $veryfy_url = $this->config['https_verify_url'];
        }
        else {
            $veryfy_url = $this->config['http_verify_url'];
        }
        $veryfy_url = $veryfy_url."partner=" . $partner . "&notify_id=" . $notify_id;
        $responseTxt = $this->request->curlGet($veryfy_url, $this->config['cacert']);

        return $responseTxt;
    }

    private function getCharset()
    {
        return trim(strtolower($this->config['input_charset']));
    }

    public function success($message, $data=[])
    {
        return array("success"=>true, "message"=>$message, 'data'=>$data);
    }

    public function error($message, $data=[])
    {
        return array("success"=>false, "message"=>$message, 'data'=>$data);
    }

    /**
     * 获取错误内容
     *
     * @param $errorFlag 错误标识
     * @return mixed 错误内容
     */
    public function getErrorMessage($type, $errorFlag)
    {

        $errors = $this->allErrorCode[$type];

        $message = isset($errors[$errorFlag]) ? $errors[$errorFlag] : '未知错误!';

        return $message;
    }

    /**
     * 异步通知处理成功后响应第三方
     */
    public function responseNotifySuccess()
    {
        echo 'success';
        return;
    }

    /**
     * 异步通知处理失败后响应第三方
     */
    public function responseNotifyFailed()
    {
        echo 'error';
        return;
    }

    public function getNotifyRequestParams()
    {
        return $_POST;
    }
}