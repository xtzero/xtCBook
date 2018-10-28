<?php
/**
 * 系统的公共函数库
 * xt 2018年10月26日
 */

/**
 * 实例化数据库模型的方法
 */
function Db($table_name){
    $model = new Model($table_name);
    return $model;
}

/**
 * 输出错误
 * xt 2018年10月26日
 */
function xtError($err){
    die($err);
}

/**
 * 向接口输出内容
 */
function ajax($code,$msg,$data = []){
    die(json_encode([
        'code' => $code,
        'msg' => $msg,
        'data' => $data
    ],JSON_UNESCAPED_UNICODE));
}