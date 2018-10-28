<?php
/**
 * 公共的控制器类
 * xt 2018年10月26日
 */
namespace lib;
class controller{
    /**
     * 验证参数方法
     * xt 2018年09月02日
     */
    public function param($method,$params){
        if(is_string($params)){
            $params_arr = explode(',',$params);
        }else if(is_array($params)){
            $params_arr = $params;
        }else{
            xtError('param方法只能接收字符串或数组');
        }

        //接收前端传值
        $data_post = $_POST;
        $data_get = $_GET;

        //都缺少什么参数
        $errParamArr = [];
        foreach($params_arr as $param){
             # 使用*号可以让这个参数非必须，这样来实现默认值
             # param('*par1=123');
            if(substr($param,0,1) == '*'){
                //当前参数是从第一位开始，按照等号分开的键值对
                $_param = substr($param,1);
                if(strpos($_param,'=')){
                    $param_ = explode('=',$_param);
                    //第一个是字段名，第二个是字段默认值
                    $param_key = $param_[0];
                    $param_default_value = $param_[1];
                }else{
                    $param_key = $_param;
                    $param_default_value = false;
                }
                
                if(in_array($method,['post','p']) && isset($data_post[$param_key])){
                    $this->{$param_key} = $data_post[$param_key];
                }else if($param_default_value){
                    $this->{$param_key} = $param_default_value;
                }else{
                    $this->{$param_key} = false;
                }
                
                if(in_array($method,['get','g']) && isset($data_get[$param_key])){
                    $this->{$param_key} = $data_get[$param_key];
                }else if($param_default_value){
                    $this->{$param_key} = $param_default_value;
                }else if(!self::$P[$param_key]){
                    $this->{$param_key} = false;
                }
            }
            //必要的参数验证
            else{
                //如果指定了参数还没传，则在标记中记录
                $noParam = false;    //当前参数没post过来
                if((in_array($method,['post','p']) && isset($data_post[$param]))){
                    $this->{$param} = $data_post[$param];
                }else if((in_array($method,['get','g']) && isset($data_get[$param]))){
                    $this->{$param} = $data_get[$param];
                }else{
                    $noParam = true;
                }
                
                //如果也没post也没get，则记录到缺值数组中
                if($noParam){
                    array_push($errParamArr,$param);
                }
            }
        }

        if(!empty($errParamArr)){
            xtError('缺少必要参数：'.implode('、',$errParamArr));
        }
    }
}
