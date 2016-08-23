<?php
// +----------------------------------------------------------------------
// | Demo [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.lmx0536.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <http://www.lmx0536.cn>
// +----------------------------------------------------------------------
// | Date: 2016/6/2 Time: 14:30
// +----------------------------------------------------------------------
namespace app\common\model;

use think\Model;

class BaseModel extends Model
{
    //use \traits\model\Transaction;//添加事务支持 BUG已修复 已不需要添加
    /**
     * 删除
     */
    public function mfnDelete($id)
    {

        $condition["id"] = $id;
        $res = $this->where($condition)->delete();
        if ($res) {
            return true;
        }
        $this->error = "删除失败！";
        return false;

    }

    /**
     * [mfnAdd 添加、编辑]
     * @Author   Limx
     * @Method   直接调用
     * @DateTime 2016-02-02T09:54:54+0800
     * @param    [type]                   $d    [所需的数据]
     * @return   [type]                         [主键ID]
     */
    public function mfnUpdate($data)
    {
        if (empty($data)) {
            $this->error = '数据不能为空！';
            return false;
        }

        if (empty($data['id'])) {
            $status = $this->save($data);
            if ($status === false) {
                $this->error = '新增出错！';
                return false;
            }
        } else {
            $condition['id'] = $data['id'];
            $status = $this->save($data, $condition);
            if (false === $status) {
                $this->error = '更新出错！';
                return false;
            }
        }
        $pk = $this->getPk();
        return $this[$pk];
    }

    /**
     * [mfnFind 获取一条信息]
     * @Author   Limx
     * @Method   直接调用
     * @DateTime 2016-02-02T09:54:54+0800
     * @param    [type]              $condition [筛选条件]
     * @return   [type]                         [description]
     */
    public function mfnFind($condition, $field = "", $lock = false)
    {
        $res = $this->lock($lock)->field($field)->where($condition)->find();

        return $res;
    }

    /**
     * [mfnSelect 获取列表]
     * @Author   Limx
     * @Method   直接调用
     * @DateTime 2016-02-02T09:54:54+0800
     * @param    [type]              $condition [筛选条件]
     * @return   [type]                         [description]
     */
    public function mfnSelect($condition = "", $pageIndex = 0, $pageSize = 10, $order = "Id desc", $field = "", $lock = false)
    {
        $start = $pageIndex * $pageSize;
        $result = $this->field($field)
            ->lock($lock)
            ->where($condition)
            ->order($order)
            ->limit("$start,$pageSize")
            ->select();
        $count = $this->where($condition)->count();
        $returnData["data"] = $result;
        $returnData["count"] = $count;
        return $returnData;
    }

    /**
     * [mfnGetTable 获取表]
     * @author limx
     * @param $tableName 表名
     * @param $like 是否模糊查询
     * @return mixed
     */
    public function mfnGetTable($tableName, $like = false)
    {
        $strSql = '';
        if ($like) {
            $strSql = "SHOW TABLES LIKE '%" . $tableName . "%'";
        } else {
            $strSql = "SHOW TABLES LIKE '" . $tableName . "'";
        }

        $arrayTableInfo = $this->query($strSql);
        return $arrayTableInfo;
    }


}