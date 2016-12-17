<?php

/**
 * 把模型转换为键值对数组
 * @param $model \Illuminate\Database\Eloquent\Model|static[]
 * @param $key string|array
 * @param $value string
 * @return array
 */
function getModelArray($model, $key, $value) {
    $result = [];
    if($model != null){
        if(is_string($key)){
            foreach ($model as &$val){
                $result[$val->{$key}] = $val->{$value};
            }
        }else if(is_array($key)){
            foreach ($model as &$val){
                $result[$val->{$key[0]}->{$key[1]}][$val->{$key[2]}] = $val->{$value};
            }
        }
    }
    return $result;
}

/**
 * 用于视图显示性别
 * @param $sex
 * @return string
 */
function getSexText($sex){
    switch ($sex){
        case 1:
            return '男';
        case 2:
            return '女';
        default:
            return '';
    }
}
