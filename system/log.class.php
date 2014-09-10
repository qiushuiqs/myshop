<?php


/*
file log.class.php
记录信息日志文件
*/

/*
如果文件大于1m，重新写一份
*/
defined('ACC')||exit('ACC Denied');


class log{
	const FILENAME = 'curr.log'; //常量：代表日志文件的名称
	private $sequence;
	protected function __construct(){
		//$sequence = generate_numbers(1,20,4);
	}
	public static function write($content){
		//调用是否需要arch
		$content .="\r\n";
		$log = self::is_arch();
		$fn = fopen($log,'a');
		fwrite($fn,$content);
		fclose($fn);
	}
	//备份日志
	private static function archive(){
		//归档成年-月-日类型文件并创建新的curr.log文件
		$log = __ROOT__.'data/log/'.self::FILENAME;
		$arch = __ROOT__.'data/log/'.date('ymd_his').'bak';
		return rename($log,$arch);
	}
	//读取并判断日志大小
	public static function is_arch(){
		$log = __ROOT__.'data/log/'.self::FILENAME;
		if(!file_exists($log)){
			touch($log);
			return $log;
		}
		//文件存在后根据大小决定是否需要创建新的log文件，1024*1024=1M
		clearstatcache();//清除文件相关函数缓存
		if(filesize($log)<1024*1024){ //注意这里filesize函数会被第一次读取缓存，直到php进程结束
			return $log;
		}else{
			if(self::archive()){
				touch($log);
				return $log;
			}else{
				return $log;
			}
		}
	}
}