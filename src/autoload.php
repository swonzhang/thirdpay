<?php

/**
 * 自动加载函数
 *
 * @param $classname string 被加载的类名
 */
function jn_load($classname)
{
    //PHP 5.3以下版本不能使用__DIR__
    $classname = str_replace('Jueneng\\', '', $classname);
    $classname = str_replace('\\', '/', $classname);
    $filename = dirname(__FILE__).DIRECTORY_SEPARATOR.$classname.'.php';

    if (is_readable($filename)) {
        include_once $filename;
    }
}

if (version_compare(PHP_VERSION, '5.1.2', '>=')) {
    if (version_compare(PHP_VERSION, '5.3.0', '>=')) {
        spl_autoload_register('jn_load', true, true);
    } else {
        spl_autoload_register('jn_load');
    }
} else {
    /**
     * 低PHP版本加载
     *
     * @param string $classname 被加载的类名
     */
    function __autoload($classname)
    {
        jn_load($classname);
    }
}