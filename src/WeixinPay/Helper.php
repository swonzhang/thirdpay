<?php

namespace Jueneng\WeixinPay;

/**
 * 微信支付辅助函数类
 */
class Helper
{
    /**
     * 解码unicode字符串
     *
     * @param $str
     * @return mixed
     */
    public static function decodeUnicode($str)
    {
        return preg_replace_callback('/\\\\u([0-9a-f]{4})/i',
            create_function(
                '$matches',
                'return mb_convert_encoding(pack("H*", $matches[1]), "UTF-8", "UCS-2BE");'
            ),
            $str);
    }

    /**
     * 数组转换成xml
     *
     * @param $data
     * @return string
     */
    public static function toXml($data)
    {
        $xml = "<xml>";
        foreach ($data as $key=>$val)
        {
            if (is_numeric($val)){
                $xml.="<".$key.">".$val."</".$key.">";
            }else{
                $xml.="<".$key."><![CDATA[".$val."]]></".$key.">";
            }
        }
        $xml.="</xml>";
        return $xml;
    }

    /**
     * 参数数组转换成指定加密格式字符串
     *
     * @param $param
     * @return string
     */
    public static function setParams(&$param)
    {
        $arr_req = array();
        foreach($param as $key=>$value){
            if(is_array($value)) {
                $arr_req[] = "${key}=".implode("&",$value);
            } else {
                if ($value == '') {
                    continue;
                }
                $arr_req[] = "${key}=${value}";
            }
        }
        $str = implode("&",$arr_req);

        return $str;
    }
}