<?php

namespace App\Models;


use App\Events\UserGroupDeleted;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserGroup extends BaseModel
{

    use SoftDeletes;

    protected $table = 'user_group';

    protected $dispatchesEvents = [
        'deleted' => UserGroupDeleted::class
    ];

    /**
     * 关联商品
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     *
     * @author    assimon<ashang@utf8.hk>
     * @copyright assimon<ashang@utf8.hk>
     * @link      http://utf8.hk/
     */
    public function user()
    {
        return $this->hasMany(User::class, 'group_id');
    }

}
