<?php
/**
 * Created by PhpStorm.
 * User: dream
 * Date: 2018/6/17
 * Time: 下午12:47
 */

namespace App\Common;


use App\http\Model\Menu;

class Common
{
    /**
     * 表单提交非法字符过滤处理
     * @param $array
     * @return array|mixed|string
     */
    public static function dataCheck($array,$status = true)
    {
        if (!empty($array)) {
            if (!get_magic_quotes_gpc()) {
                if (is_array($array)) {
                    foreach ($array as $key => $val) {
                        $array[$key] = self::dataCheck($val);
                    }
                } else {
                    $array = addslashes($array);
                }
                $array = str_replace("&#x", "& # x", $array); //过滤一些不安全字符s
                $array = str_replace("<", "&lt;", $array); //过滤<
            }
            if ($status) {
                if (isset($array['_token'])) {
                    unset($array['_token']);
                }
            }
        }
        return $array;
    }

    /**
     * 组装json返出数据
     * @param $code
     * @param $msg
     * @param null $data
     */
    public static function jsonOutData($code=201,$msg="操作失败!~",$data=null)
    {
        return [
            'code'=>$code,
            'msg'=>$msg,
            'data'=>$data
        ];
    }

    /**
     * 无限极分类 选择框用
     * @param int $parentId
     * @return array
     */
    public static function tree($parentId = 0)
    {
        $rows = Menu::where('parent_id', $parentId)->orderBy('sort','asc')->get()->toArray();
        $arr = array();

        if (sizeof($rows) != 0){
            foreach ($rows as $key => $val){
                $val['list'] = self::tree($val['id']);
                $arr[] = $val;
            }
            return $arr;
        }
    }

    /**
     * 视图用树形数据
     * @param $data
     * @param int $pid
     * @param int $count
     * @return array
     */
    public static function getTree($data, $pid = 0, $count = 0)
    {
        //因为函数再每次调用时都会将之前的数据清空,所以要声明一个静态变量
        static $res = [];
        //对原数组进行遍历,一次去除每一个分类的记录
        foreach ($data as $v) {
            //保存一个计数
            if ($v['parent_id'] == $pid) {
                $v['count'] = $count;
                //将汉字类信息保存在新的数组里面
                $res[] = $v;
                //在继续执行,需要传递处理分类的数组,遍历的时候记录ID
                self::getTree($data,$v['id'],$count + 1);
            }
        }
        return $res;
    }

    /**
     * 所有列表统一调用
     * @return int  默认显示10条数据
     */
    public static function pageSize()
    {
        return 10;
    }


}
