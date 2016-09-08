ThirdPay(程序包还未发布)
===============
[![Latest Stable Version](https://poser.pugx.org/jaydenguo/thirdpay/v/stable)](https://packagist.org/packages/jaydenguo/thirdpay)
[![Total Downloads](https://poser.pugx.org/jaydenguo/thirdpay/downloads)](https://packagist.org/packages/jaydenguo/thirdpay)
[![Latest Unstable Version](https://poser.pugx.org/jaydenguo/thirdpay/v/unstable)](https://packagist.org/packages/jaydenguo/thirdpay)
[![License](https://poser.pugx.org/jaydenguo/thirdpay/license)](https://packagist.org/packages/jaydenguo/thirdpay)

该项目封装了支付宝app支付，扫码支付，wap支付，即时到账支付以及微信app支付，微信扫码支付。
它提供了统一而简洁的调用接口，主要目的是让接入支付宝和微信支付的开发工作变得更加简单优雅。
目前只提供**支付**和**退款**功能。

该项目的作者是 [郭觉能](http://www.jueneng.org).

* [安装](#安装)
* [配置](#配置)
* [示例](#示例)
* [用法](#用法)
* [其他](#其他)
* [最后](#最后)

## 安装
+ 第一种方式 直接下载程序包，然后在项目中包含*autoload.php*  
```php
    include_once '包的根目录/src/autoload.php';
```

+ 第二种方式 用composer安装，在composer.json中指定安装*jaydenguo/thirdpay*  
```js
    "require": {
        "jaydenguo/thirdpay": "1.0.*"
    }
```
## 配置
每一种支付方式的配置项都是一个数组。example/config文件夹中列出了各个支付方式的配置项，配置项的键名不能随意修改，
你可以根据你的情况以最合适的方式引入这些配置项。 例如假设你使用thinkphp框架开发，这些支付配置项就可以放在thinkphp
的配置文件中，再通过C方法引入。 

>支付接入最大的难点之一是准确理解并填写这些配置项，否则很容易遇到签名等问题。

## 示例
这个程序包提供了各个方式的支付和退款示例，你可以填写好配置项后，搭建好本地环境运行看看。

## 用法
###实例化支付对象
```php
$pay = \Jueneng\Pay::getInstance('alipay.direct');
$pay = $pay->setConfig($config);
```
给*getInstance*方法传入参数*alipay.direct*表示实例化的是支付宝即使到账支付对象。所有的标识如下:

支付宝即时到帐支付: *alipay.direct*(对应支付宝旧版接口)  
支付宝app支付: *alipay.app*(对应支付宝新版接口)   
支付宝扫码支付: *alipay.qr*(对应支付宝新版接口)   
支付宝wap支付: *alipay.wap*(对应支付宝新版接口)   
微信扫码支付: *weixinpay.qr*  
微信app支付: *weixinpay.app*    
###发起支付
```php
$result = $pay->createOrder($params);
```
$params是从外部传入的参数数组，具体请求参数请参考对应的官方文档。
>请勿传入在请求之前就已经确定的参数，比如charset,app_id,sign_type等，
因为这个包里面已经预先设置好了这些参数，你也可以参照示例来传，以及查看
对应的参数请求类，比如支付的参数请求类是CreateOrderRequestParam。

返回的$result是一个数组，包含3个字段message,success,data，
message是返回消息，success是发起支付是否成功，true是成功，false是失败，
data是原始返回数据

###发起退款
```php
$result = $pay->refund($params);
```
$params是从外部传入的参数数组，具体请求参数请看对应的官方文档。  
返回的$result是一个数组，包含3个字段message,success,data，
message是返回消息，success是发起支付是否成功，true是成功，false是失败，
data是原始返回数据

###验证回跳或异步通知参数
```php
$params = \Jueneng\AliPay\Helper::getNotifyRequestParams();
$result = $pay->verifyRefund($params);
```
$result是bool类型，true是验证成功，false是验证失败。异步通知回调验证等于true时，
需要给第三方支付返回指定字符串，调用如下方法返回:
```php
return $pay->responseNotifySuccess();
```
##其他
以下是官方文档链接:
+ [支付宝即时到帐支付](https://doc.open.alipay.com/doc2/detail?treeId=62&articleId=103566&docType=1)
+ [支付宝wap支付](https://doc.open.alipay.com/doc2/detail?treeId=203&articleId=105288&docType=1)
+ [支付宝扫码支付](https://doc.open.alipay.com/docs/doc.htm?spm=a219a.7629140.0.0.548tMo&treeId=194&articleId=105203&docType=1)
+ [支付宝app支付](https://doc.open.alipay.com/doc2/detail?treeId=204&articleId=105051&docType=1)
+ [支付宝无密退款](https://doc.open.alipay.com/doc2/detail?treeId=62&articleId=103566&docType=1)
+ [微信扫码支付](https://pay.weixin.qq.com/wiki/doc/api/native.php?chapter=6_1)
+ [微信app支付](https://pay.weixin.qq.com/wiki/doc/api/app/app.php?chapter=8_1)

>支付宝有两个版本接口，一个新版的，一个旧版的，一定要认清文档的版本

##最后
如你发现该程序包的任何bug，请用邮件联系我**453539025@qq.com**，我将会以最快速度修复。