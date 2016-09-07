<?php

namespace Jueneng\WeixinPay;

use Jueneng\BaseRequest;

class Request extends BaseRequest
{
    /**
     * 带证书请求
     *
     * @param $url string 请求的网址
     * @param $vars 请求的参数
     * @param $certPemPath string 证书路径
     * @param $keyPemPath  string 证书路径
     * @param int $second  int 请求超时时间
     * @param array $aHeader array 请求头选项
     * @return mixed
     */
    function curlPostWithCert($url, $vars, $certPemPath, $keyPemPath, $second=50,$aHeader=array())
    {
        $ch = curl_init();
        //超时时间
        curl_setopt($ch,CURLOPT_TIMEOUT,$second);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,2);
        curl_setopt($ch,CURLOPT_SSLCERTTYPE,'PEM');
        curl_setopt($ch,CURLOPT_SSLCERT, $certPemPath);  //__DIR__ . '/cert/apiclient_cert.pem'
        curl_setopt($ch,CURLOPT_SSLKEYTYPE,'PEM');
        curl_setopt($ch,CURLOPT_SSLKEY, $keyPemPath); //__DIR__ . '/cert/apiclient_key.pem'

        if( count($aHeader) >= 1 ){
            curl_setopt($ch, CURLOPT_HTTPHEADER, $aHeader);
        }

        curl_setopt($ch,CURLOPT_POST, 1);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$vars);
        $result = curl_exec($ch);
        if($result === false){
            $error = curl_error($ch);
            echo "curl错误信息:$error\n";
        }

        curl_close($ch);
        return $result;
    }
}