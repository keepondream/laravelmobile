<?php

namespace App\http\Model;

use Illuminate\Database\Eloquent\Model;

class AdminUser extends Model
{
    /**
     * 与模型关联的数据表
     *
     * @var string
     */
    protected $table = 'admin_users';


    protected $fillable = ['name','password'];
}
