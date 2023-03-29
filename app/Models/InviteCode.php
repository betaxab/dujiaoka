<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InviteCode extends Model
{
    protected $guarded = [];
    protected $table = 'invite_code';

    // 尚未使用
    const CODE_STATUS_UNUSED = 0;
    // 已经使用
    const CODE_STATUS_USED = 1;

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
    public static function getInviteCodeStatusMap()
    {
        return [
            self::CODE_STATUS_UNUSED => admin_trans('invite-code.fields.status_unused'),
            self::CODE_STATUS_USED => admin_trans('invite-code.fields.status_used')
        ];
    }
}
