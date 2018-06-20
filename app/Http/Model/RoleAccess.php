<?php

namespace App\http\Model;

use Illuminate\Database\Eloquent\Model;

class RoleAccess extends Model
{
    //
    /**
     * 与模型关联的数据表
     *
     * @var string
     */
    protected $table = 'role_accesses';

    /**
     * 可以被批量赋值的属性。
     *
     * @var array
     */
    protected $fillable = ['role_id','access_id'];

}
