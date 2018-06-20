<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->commit('菜单名称');
            $table->string('url')->commit('菜单地址');
            $table->string('icon')->default('&#xe620;')->commit('菜单图标');
            $table->unsignedInteger('parent_id')->default('0')->index()->commit('父级菜单ID');
            $table->string('sort')->default('50')->commit('排序');
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
        Schema::dropIfExists('menus');
    }
}
