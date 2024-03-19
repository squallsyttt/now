<?php

namespace app\admin\model;

use think\Model;


class Nowbreathnew extends Model
{

    

    

    // 表名
    protected $name = 'nowbreathnew';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = false;

    // 定义时间戳字段名
    protected $createTime = false;
    protected $updateTime = false;
    protected $deleteTime = false;

    // 追加属性
    protected $append = [
        'mode_type_text'
    ];
    

    
    public function getModeTypeList()
    {
        return ['478' => __('Mode_type 478'), '44' => __('Mode_type 44')];
    }


    public function getModeTypeTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['mode_type']) ? $data['mode_type'] : '');
        $list = $this->getModeTypeList();
        return isset($list[$value]) ? $list[$value] : '';
    }




}
