<?php

return [
    /**
     * 退款错误码和描述对应数组
     */
    'refund' => [
        'illegal_sign' => '非法签名',
        'illegal_user'=>	'用户id不正确',
        'batch_num_exceed_limit'=>	'总比数大于1000',
        'refund_date_error'=>	'错误的退款时间',
        'batch_num_error'=>	'传入的总笔数格式错误',
        'batch_num_not_equal_total'=>	'传入的退款条数不等于数据集解析出的退款条数',
        'single_detail_data_exceed_limit'=>	'单笔退款明细超出限制',
        'not_this_seller_trade'=>	'不是当前卖家的交易',
        'dubl_trade_no_in_same_batch'=>	'同一批退款中存在两条相同的退款记录',
        'duplicate_batch_no'=>	'重复的批次号',
        'trade_status_error'=>	'交易状态不允许退款',
        'batch_no_format_error'=>	'批次号格式错误',
        'seller_info_not_exist'=>	'卖家信息不存在',
        'partner_not_sign_protocol'=>	'平台商未签署协议',
        'not_this_partners_trade'=>	'退款明细非本合作伙伴的交易',
        'detail_data_format_error'=>	'数据集参数格式错误',
        'pwd_refund_not_allow_royalty'=>	'有密接口不允许退分润',
        'nanhang_refund_charge_amount_error'=>	'退票面价金额不合法',
        'refund_amount_not_valid'=>	'退款金额不合法',
        'trade_product_type_not_allow_refund'=>	'交易类型不允许退交易',
        'result_face_amount_not_valid'=>	'退款票面价不能大于支付票面价',
        'refund_charge_fee_error'=>	'退收费金额不合法',
        'reason_refund_charge_err'=>	'退收费失败',
        'result_amount_not_valid'=>	'退收费金额错误',
        'result_account_no_not_valid'=>	'账号无效',
        'reason_trade_refund_fee_err'=>	'退款金额错误',
        'reason_has_refund_fee_not_match'=>	'已退款金额错误',
        'txn_result_account_status_not_valid'=>	'账户状态无效',
        'txn_result_account_balance_not_enough'=>	'账户余额不足',
        'reason_refund_amount_less_than_coupon_fee'=>	'红包无法部分退款'
    ],

    /**
     * 扫码支付错误码和描述对应数组
     */
    'qrpay' => [
        'acq.system_error' =>	'接口返回错误',
        'acq.invalid_parameter'=>	'参数无效',
        'acq.access_forbidden'=>	'无权限使用接口',
        'acq.exist_forbidden_word'=>	'订单信息中包含违禁词	修改订单信息后，重新发起请求',
        'acq.partner_error'=>	'应用app_id填写错误',
        'acq.total_fee_exceed'=>	'订单总金额超过限额',
        'acq.context_inconsistent'=>	'交易信息被篡改',
        'acq.trade_has_success'=>	'交易已被支付',
        'acq.trade_has_close'=>	'交易已经关闭',
        'acq.buyer_seller_equal'=>	'买卖家不能相同',
        'acq.trade_buyer_not_match'=>	'交易买家不匹配',
        'acq.buyer_enable_status_forbid'=>	'买家状态非法',
        'acq.buyer_payment_amount_day_limit_error'=>	'买家付款日限额超限',
        'acq.beyond_pay_restriction'=>	'商户收款额度超限',
        'acq.beyond_per_receipt_restriction'=>	'商户收款金额超过月限额',
        'acq.buyer_payment_amount_month_limit_error'=>	'买家付款月额度超限',
        'acq.seller_been_blocked'=>	'商家账号被冻结',
        'acq.error_buyer_certify_level_limit'=>	'买家未通过人行认证',
        'acq.invalid_store_id'=> '商户门店编号无效	检查传入的门店编号是否符合规则',
    ]
];