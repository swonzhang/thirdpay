<?php
namespace Jueneng\AliPay\Sign;

use Jueneng\Interfaces\SignInterface;

class Md5Sign implements SignInterface
{

    /**
     * 签名字符串
     *
     * @param $prestr 需要签名的字符串
     * @param $key 私钥
     * @return string 签名结果
     */
    public function createSign($prestr, $key)
    {
        $prestr = $prestr . $key;

        return md5($prestr);
    }

    /**
     * 验证签名
     *
     * @param $prestr 需要签名的字符串
     * @param $sign 签名结果
     * @param $key 私钥
     * @return bool 签名结果
     */
    public function verifySign($data, $key)
    {
        $prestr = $data['prestr'];
        $sign = $data['sign'];
        $prestr = $prestr . $key;
        $mysgin = md5($prestr);

        if($mysgin == $sign) {
            return true;
        }

        return false;
    }
}