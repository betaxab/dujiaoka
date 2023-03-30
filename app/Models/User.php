<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users';

    // 返利跟随系统
    const COMMISSION_TYPE_SYSTEM = 0;
    // 首次返利
    const COMMISSION_TYPE_ONETIME = 1;
    // 循环返利
    const COMMISSION_TYPE_CYCLE = 2;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * 关联受邀用户
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     *
     */
    public function invite_user()
    {
        return $this->belongsTo(self::class, 'invite_user_id', 'id');
    }

    /**
     * 获取组件映射
     *
     * @return array
     *
     */
    public static function getCommissionTypeMap()
    {
        return [
            self::COMMISSION_TYPE_SYSTEM => admin_trans('user.options.commission_system'),
            self::COMMISSION_TYPE_ONETIME => admin_trans('user.options.commission_onetime'),
            self::COMMISSION_TYPE_CYCLE => admin_trans('user.options.commission_cycle'),
        ];
    }
}
