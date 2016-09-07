<?php
namespace Jueneng\Interfaces;


interface SignInterface
{
    /**
     * 创建签名
     *
     * @param $params
     * @param $key
     * @return mixed
     */
    public function createSign($params, $key);

    /**
     * 验证签名
     *
     * @param $params
     * @param $key
     * @return mixed
     */
    public function verifySign($params, $key);
}