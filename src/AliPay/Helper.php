<?php

namespace Jueneng\AliPay;


class Helper
{
    /**
     * 实现多种字符编码方式
     *
     * @param $input 需要编码的字符串
     * @param $_output_charset 输出的编码格式
     * @param $_input_charset 输入的编码格式
     * @return string 编码后的字符串
     */
    public static function charsetEncode($input,$_output_charset ,$_input_charset)
    {
        if(!isset($_output_charset) )$_output_charset  = $_input_charset;
        if($_input_charset == $_output_charset || $input ==null ) {
            $output = $input;
        } elseif (function_exists("mb_convert_encoding")) {
            $output = mb_convert_encoding($input,$_output_charset,$_input_charset);
        } elseif(function_exists("iconv")) {
            $output = iconv($_input_charset,$_output_charset,$input);
        } else die("sorry, you have no libs support for charset change.");

        return $output;
    }

    /**
     * 实现多种字符解码方式
     *
     * @param $input 需要解码的字符串
     * @param $_input_charset 输出的解码格式
     * @param $_output_charset 输入的解码格式
     * @return string 解码后的字符串
     */
    public static function charsetDecode($input,$_input_charset ,$_output_charset)
    {
        if(!isset($_input_charset) )$_input_charset  = $_input_charset ;
        if($_input_charset == $_output_charset || $input ==null ) {
            $output = $input;
        } elseif (function_exists("mb_convert_encoding")) {
            $output = mb_convert_encoding($input,$_output_charset,$_input_charset);
        } elseif(function_exists("iconv")) {
            $output = iconv($_input_charset,$_output_charset,$input);
        } else die("sorry, you have no libs support for charset changes.");

        return $output;
    }

    /**
     * 生成要请求给支付宝的参数数组
     *
     * @param $para_temp 请求前的参数数组
     * @param $isNew 新版支付宝接口签名时包含sign_type,所以以此参数来区别是否是新版接口
     * @return mixed 要请求的参数数组
     */
    public static function buildRequestPreStr($para_temp, $isNew=false)
    {
        //除去待签名参数数组中的空值和签名参数
        $para_filter = self::paraFilter($para_temp, $isNew);

        //对待签名参数数组排序
        $para_sort = self::argSort($para_filter);

        //把数组所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串
        $prestr = self::createLinkstring($para_sort);

        return $prestr;
    }

    /**
     * 除去数组中的空值和签名参数
     *
     * @param $para 签名参数组
     * @return array 去掉空值与签名参数后的新签名参数组
     */
    public static function paraFilter($para, $isNew=false)
    {
        if (!$isNew) {
            unset($para['sign_type']);
        }
        $para_filter = array();
        while (list ($key, $val) = each ($para)) {
            if($key == "sign" || $val == "") {
                continue;
            } else {
                $para_filter[$key] = $para[$key];
            }
        }

        return $para_filter;
    }

    /**
     * 对数组排序
     *
     * @param $para 排序前的数组
     * @return mixed 排序后的数组
     */
    public static function argSort($para)
    {
        ksort($para);
        reset($para);
        return $para;
    }

    /**
     * 把数组所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串
     *
     * @param $para 需要拼接的数组
     * @return string 拼接完成以后的字符串
     */
    public static function createLinkstring($para)
    {
        $arg  = "";
        while (list ($key, $val) = each ($para)) {
            $arg.=$key."=".$val."&";
        }
        //去掉最后一个&字符
        $arg = substr($arg,0,count($arg)-2);

        return $arg;
    }

    /**
     * 把数组所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串，并对字符串做urlencode编码
     *
     * @param $para 需要拼接的数组
     * @return string 拼接完成以后的字符串
     */
    public static function createLinkstringUrlencode($para)
    {
        $arg  = "";
        while (list ($key, $val) = each ($para)) {
            $arg.=$key."=".urlencode($val)."&";
        }
        //去掉最后一个&字符
        $arg = substr($arg,0,count($arg)-2);

        return $arg;
    }

    /**
     * 校验$value是否非空
     *  if not set ,return true;
     *    if is null , return true;
     **/
    public static function checkEmpty($value)
    {
        if (!isset($value)){
            return true;
        }

        if ($value === null){
            return true;
        }

        if (trim($value) === "") {
            return true;
        }

        return false;
    }

    /**
     * 数组转换成功BizContent参数指定格式
     *
     * @param array $params
     * @return string
     */
    public static function convertToBizContentFormat(Array $params)
    {
        $bizContent = json_encode($params, JSON_UNESCAPED_SLASHES | JSON_FORCE_OBJECT | JSON_UNESCAPED_UNICODE);

        return $bizContent;
    }

    /**
     * 获取异步通知或会跳的参数
     *
     * @return mixed
     */
    public function getNotifyRequestParams()
    {
        return $_POST;
    }
}