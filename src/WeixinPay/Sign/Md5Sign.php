<?php
namespace Jueneng\WeixinPay\Sign;

use Jueneng\Interfaces\SignInterface;
use Jueneng\WeixinPay\Helper;

class Md5Sign implements SignInterface {

    /**
     * 验证签名
     *
     * @param $result
     * @param $key
     * @return bool
     */
    public function verifySign($result, $key)
    {
        $sign_text = $result['sign'];
        $sign = $this->createSign($result, $key);
        return ($sign == $sign_text);
    }

    /**
     * 创建签名
     *
     * @param $result
     * @param $key
     * @return string
     */
    public function createSign($result, $key)
    {
        unset($result['sign']);

        ksort($result);

        $str = Helper::setParams($result);
        $str .= "&key=".$key;
        $sign = strtoupper(md5($str));

        return $sign;
    }

    /**
     * 组转签名的字符串
     *
     * @param $data
     * @param $partnerId
     * @return int|string
     */
    public function getSignText($data, $partnerId)
    {
        foreach ($data as $key=>$value) {
            if ($value === '' or $value === null) {
                unset($data[$key]);
            }
        }
        ksort($data);

        $str = Helper::setParams($data);
        $str .= "&key=".$partnerId;
        $key = strtoupper(md5($str));

        return $key;
    }
}