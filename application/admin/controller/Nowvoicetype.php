<?php

namespace app\admin\controller;

use app\common\controller\Backend;
use think\Db;

/**
 * 
 *
 * @icon fa fa-circle-o
 */
class Nowvoicetype extends Backend
{

    /**
     * Nowvoicetype模型对象
     * @var \app\admin\model\Nowvoicetype
     */
    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\admin\model\Nowvoicetype;

    }

    /**
     * 默认生成的控制器所继承的父类中有index/add/edit/del/multi五个基础方法、destroy/restore/recyclebin三个回收站方法
     * 因此在当前控制器中可不用编写增删改查的代码,除非需要自己控制这部分逻辑
     * 需要将application/admin/library/traits/Backend.php中对应的方法复制到当前控制器,然后进行修改
     */

    /**
     * 声音管理时 关联获取声音类型data-source 的数据
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getVoiceTypeSelect()
    {
        $typeList = Db::name('nowvoicetype')->field('type_id,type_name')->select();
        return ['list' => $typeList,'total' => count($typeList)];
    }
}
