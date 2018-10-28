<?php
/**
 * 模型类
 * xt 2018年10月26日
 */

class Model{
    /**
     * 当前链接
     */
    protected $db;

    /**
     * 数据表名
     */
    protected $_table;

    /**
     * 当前sql语句
     */
    protected $_sql;

    /**
     * 构造方法
     * @param $table    数据表名
     * @param $options  其他配置项
     */
    public function __construct($table,$options = []){
        //读取数据库配置
        $config = include('config.php');

        //连接数据库
        $this->db = (function($config){
            $con = mysqli_connect($config['db_host'],$config['db_usr'],$config['db_pwd']);
            if($con){
                return $con;
            }else{
                xtError('数据库链接出错，请检查数据库配置：<br/>'.json_encode($config).'<br/>'.mysqli_error($con));
            }
        })($config);

        //选择数据库
        $this->selectDb($config['db_name']);

        //设置数据表
        $this->_table = $table;

        return $this;
    }

    public function __set($key,$value){
        $this->${$key} = $value;
        return $this;
    }

    /**
     * 选择数据库
     * xt 2018年10月26日
     */
    public function selectDb($dbName){
        if(!mysqli_select_db($this->db,$dbName)){
            xtError(mysqli_error($this->db));
        }
        return $this;
    }

    /**
     * 选择数据表
     * xt 2018年10月26日
     */
    public function selectTable($table){
        return $this->__set('_table',$table);
    }

    /**
     * 直接执行sql
     * xt 2018年10月26日
     */
    public function query($sql){
        $this->_sql = $sql;
        echo 'running sql:'.$this->_sql;
    }

    /**
     * 输出当前sql
     * xt 2018年10月26日
     */
    public function _sql(){
        echo $this->$_sql;
    }
}