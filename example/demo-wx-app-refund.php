<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>微信扫码退款示例</title>
</head>
<body>
<form action="" method="post">
    <table>
        <thead>
            <td></td>
            <td>微信APP退款示例</td>
        </thead>
        <tr>
            <td>商户订单号: </td>
            <td>
                <input type="text" name="out_trade_no" value="<?php echo (isset($_POST['out_trade_no'])?$_POST['out_trade_no']:'');?>">
            </td>
        </tr>

        <tr>
            <td>退款号: </td>
            <td>
                <input type="text" name="out_refund_no" value="<?php echo (isset($_POST['out_refund_no'])?$_POST['out_refund_no']:'');?>">
            </td>
        </tr>

        <tr>
            <td>订单金额: </td>
            <td>
                <input type="text" name="total_fee" value="<?php echo (isset($_POST['total_fee'])?$_POST['total_fee']:'');?>">
            </td>
        </tr>

        <tr>
            <td>退款金额: </td>
            <td>
                <input type="text" name="refund_fee" value="<?php echo (isset($_POST['refund_fee'])?$_POST['refund_fee']:'');?>">
            </td>
        </tr>

        <tr>
            <td> </td>
            <td>
                <button type="submit">立即退款</button>
            </td>
        </tr>
    </table>
</form>
</body>
</html>
<?php
include_once __DIR__.'/../src/autoload.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $config = include_once __DIR__.'/config/wx-app.php';
    $pay = \Jueneng\Pay::getInstance('weixinpay.app');
    $pay->setConfig($config);
    $result = $pay->refund($_POST);

    var_dump($result);
    var_dump('执行结束');
}


