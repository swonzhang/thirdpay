<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>支付宝无密退款示例</title>
</head>
<body>
<form action="" method="post">
    <table>
        <thead>
            <td></td>
            <td>支付宝无密退款示例</td>
        </thead>
        <tr>
            <td>退款号: </td>
            <td>
                <input type="text" name="batch_no" value="<?php echo (isset($_POST['batch_no'])?$_POST['batch_no']:'');?>">
            </td>
        </tr>

        <tr>
            <td>交易号: </td>
            <td>
                <input type="text" name="trade_no" value="<?php echo (isset($_POST['trade_no'])?$_POST['trade_no']:'');?>">
            </td>
        </tr>


        <tr>
            <td>退款金额: </td>
            <td>
                <input type="text" name="price" value="<?php echo (isset($_POST['price'])?$_POST['price']:'');?>">
            </td>
        </tr>


        <tr>
            <td>原因: </td>
            <td>
                <input type="text" name="reason" value="<?php echo (isset($_POST['reason'])?$_POST['reason']:'');?>">
            </td>
        </tr>

        <tr>
            <td> </td>
            <td>
                <button type="submit">立即退款</button></td>
        </tr>
    </table>
</form>
</body>
</html>
<?php
include_once __DIR__.'/../src/autoload.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $config = include_once __DIR__.'/config/ali-refund.php';
    $pay = \Jueneng\Pay::getInstance('alipay.refund');
    $pay->setConfig($config);
    $result = $pay->refund($_POST);

    var_dump($result);
    var_dump('执行结束');
}


