<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique()->commit('管理名称');
            $table->string('password')->commit('管理密码');
            $table->unsignedInteger('role_id')->index()->default('0')->commit('管理角色ID');
            $table->tinyInteger('status')->default('1')->commit('账号是否锁定 默认为1:未锁定 0:锁定');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_users');
    }
}
