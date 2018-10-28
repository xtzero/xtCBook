<?php
	/**
	 * 入口文件
	 * xt 2018年10月26日
	 */
	
	//检查php版本
	if(version_compare(PHP_VERSION,'7.0.0','<')){
		die('需要PHP版本大于7.0.0!');
	}

	//需要引入的文件
	$needFiles = [
		'lib/controller.php',				//控制器类
		'lib/function.php',					//公共函数库
	];
	
	foreach($needFiles as $file){
		if(is_file($file)){
			include_once($file);
		}
	}

	//加载配置
	$config = include_once('lib/config.php');

	//解析路径
	//不用解析了，直接找index
	include_once("public/index.php");
	$CLASS = new index();
	$CLASS -> index();