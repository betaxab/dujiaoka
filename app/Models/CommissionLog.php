<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommissionLog extends Model
{

    protected $guarded = [];
    protected $table = 'commission_log';

    // 可以提现
    const COMMISSION_WITHDRAWABLE = 1;
    // 已经提现
    const COMMISSION_WITHDRAWN = 2;

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
     * 关联受邀用户
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     *
     */
    public function invite_user()
    {
        return $this->belongsTo(User::class, 'invite_user_id', 'id');
    }

    /**
     * 关联订单
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     *
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * 获取组件映射
     *
     * @return array
     *
     */
    public static function getCommissionStatusMap()
    {
        return [
            self::COMMISSION_WITHDRAWABLE => admin_trans('commission-log.fields.commission_withdrawable'),
            self::COMMISSION_WITHDRAWN => admin_trans('commission-log.fields.commission_withdrawn')
        ];
    }
}
