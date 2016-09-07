<?php

namespace Jueneng;

/**
 * 网络请求基类
 */
class BaseRequest
{
    /**
     * 网络请求
     *
     * @param $url string 请求的网址
     * @param $postfields 提交的参数
     * @param array $headers array 请求头选项
     * @return mixed
     */
    public function curlPost($url, $postfields, array $headers = array() )
    {
        $ci = curl_init();
        /* Curl settings */
        curl_setopt( $ci, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0 );
        curl_setopt( $ci, CURLOPT_CONNECTTIMEOUT, 30 );
        curl_setopt( $ci, CURLOPT_TIMEOUT, 30 );
        curl_setopt( $ci, CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ci, CURLOPT_ENCODING, 'gzip' );
        curl_setopt( $ci, CURLOPT_FOLLOWLOCATION, true );
        curl_setopt( $ci, CURLOPT_MAXREDIRS, 5 );
        curl_setopt( $ci, CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt( $ci, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt( $ci, CURLOPT_HEADER, false );

        curl_setopt( $ci, CURLOPT_POST, true );
        if ( !empty( $postfields ) ){
            curl_setopt( $ci, CURLOPT_POSTFIELDS, ( $postfields ) );
        }

        curl_setopt($ci, CURLOPT_URL, $url );
        curl_setopt($ci, CURLOPT_HTTPHEADER, $headers );
        curl_setopt($ci, CURLINFO_HEADER_OUT, true );
        $response = curl_exec( $ci );
        if($response === false){
            $error = curl_error($ci);
            echo "curl错误信息:$error\n";
        }
        curl_close ($ci);

        return $response;
    }
}