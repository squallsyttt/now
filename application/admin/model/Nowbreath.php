<?php

namespace app\admin\model;

use think\Model;


class Nowbreath extends Model
{

    

    

    // 表名
    protected $name = 'nowbreath';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = false;

    // 定义时间戳字段名
    protected $createTime = false;
    protected $updateTime = false;
    protected $deleteTime = false;

    // 追加属性
    protected $append = [
        'breath_use_scenes_list_text'
    ];
    

    
    public function getBreathUseScenesListList()
    {
        return ['478' => __('Breath_use_scenes_list 478'), '44' => __('Breath_use_scenes_list 44')];
    }


    public function getBreathUseScenesListTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['breath_use_scenes_list']) ? $data['breath_use_scenes_list'] : '');
        $valueArr = explode(',', $value);
        $list = $this->getBreathUseScenesListList();
        return implode(',', array_intersect_key($list, array_flip($valueArr)));
    }

    protected function setBreathUseScenesListAttr($value)
    {
        return is_array($value) ? implode(',', $value) : $value;
    }


}
