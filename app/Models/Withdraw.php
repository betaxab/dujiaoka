<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Withdraw extends Model
{
    protected $table = 'withdraw_log';

    // Alipay
    const WITHDRAWAL_METHOD_ALIPAY = 'alipay';

    // Wechat
    const WITHDRAWAL_METHOD_WECHAT = 'wechat';

    // USDT
    const WITHDRAWAL_METHOD_USDT = 'usdt';

    // 自定义
    const WITHDRAWAL_METHOD_CUST = 'custom';

    // 划转至余额
    const WITHDRWAL_TYPE_TO_BALANCE = 1;

    // 提现到账户
    const WITHDRWAL_TYPE_TO_ACCOUNT = 2;

    // 状态：审核中
    const STATUS_PENDING = 0;

    // 状态：已完成
    const STATUS_COMPLETED = 1;

    /**
     * 关联用户
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     *
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * 获取组件映射
     *
     * @return array
     *
     */
    public static function getWithdrawalMethodMap()
    {
        return [
            self::WITHDRAWAL_METHOD_ALIPAY => admin_trans('withdraw.fields.alipay'),
            self::WITHDRAWAL_METHOD_WECHAT => admin_trans('withdraw.fields.wechat'),
            self::WITHDRAWAL_METHOD_USDT => admin_trans('withdraw.fields.usdt'),
            self::WITHDRAWAL_METHOD_CUST => admin_trans('withdraw.fields.custom'),
        ];
    }

    /**
     * 获取组件映射
     *
     * @return array
     *
     */
    public static function getWithdrawalTypeMap()
    {
        return [
            self::WITHDRWAL_TYPE_TO_BALANCE => admin_trans('withdraw.fields.to_balance'),
            self::WITHDRWAL_TYPE_TO_ACCOUNT => admin_trans('withdraw.fields.apply_for_withdrawal')
        ];
    }

    /**
     * 获取组件映射
     *
     * @return array
     *
     */
    public static function getWithdrawalStatusMap()
    {
        return [
            self::STATUS_PENDING => admin_trans('withdraw.fields.status_pending'),
            self::STATUS_COMPLETED => admin_trans('withdraw.fields.status_completed')
        ];
    }
}
