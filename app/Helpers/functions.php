<?php

/**
 * 把模型转换为键值对数组
 * @param $model
 * @param $key
 * @param $value
 * @return array
 */
function getModelArray($model, $key, $value) {
    $result = [];
    if($model != null){
        foreach ($model as &$val){
            $result[$val[$key]] = $val[$value];
        }
    }
    return $result;
}
