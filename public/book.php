<?php
namespace app;
class book{
	/**
	 * markdown转换到html的方法
	 * @param $md markdown格式的字符串，单行
	 */
	public static function singleLineMdToHtml($md){
		//# 标题
		if(false !== strpos($md,'#')){
			$hx = substr_count($md,'#');
			$innerhtml = substr($md,strrpos($md,'# ') + 2);
			$html = "<h{$hx}>{$innerhtml}<h{$hx}/>";
		}

		else if(false !== strpos($md,'#')){
			
		}


		return $html;
	}
}