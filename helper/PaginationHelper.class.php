<?php
/*
	分页类
*/
defined('ACC')||exit('ACC Denied');

class PaginationHelper{
	protected $cntPage = 0;
	protected $perPage;
	protected $curPage;
	
	public function __construct($total, $perPage = 7, $curPage = 1){
		if($perPage < 1){
			$perPage = 1;
		}
		if($curPage < 1){
			$curPage = 1;
		}
		$this->cntPage = ceil(($total+0)/$perPage);
		$this->perPage = $perPage+0;
		$this->curPage = $curPage+0;
	}
	
	public function showPageMenu(){
		
		//保留地址栏除page=？之外的参数。之后加入page=任意值来实现分页。
		$url = $_SERVER['REQUEST_URI'];
		$parse = parse_url($url);
		if(isset($parse['query'])){
			parse_str($parse['query'],$block);
		}else{
			$block =array();
		}
		unset($block['page']);
		$postfix = http_build_query($block);
		$prefix = $parse['path'].'?';
		if(empty($postfix)){
			$url = $prefix.'page=';
		}else{
			$url = $prefix.$postfix.'&page=';
		}
		
		
		//实现分页导航界面，以及下一页上一页，结尾和开头
		$pagebar = array();
		$pagebar[] = '<span class="page_now">'.$this->curPage.'</span>';
		for($lt = $this->curPage-1,$rt = $this->curPage+1; ($lt>0||$rt<=$this->cntPage)&&count($pagebar)<5;$lt--,$rt++){
			if($lt>0){
				$code = '<a href="'.$url.$lt.'">['.$lt.']</a>';
				array_unshift($pagebar, $code);
			}
			if($rt<=$this->cntPage){
				$code = '<a href="'.$url.$rt.'">['.$rt.']</a>';
				array_push($pagebar, $code);
			}
		}
		if($this->curPage>1){
			$before =  '<a href="'.$url.($this->curPage-1).'" class="next">上一页</a>';
			array_unshift($pagebar, $before);
		}
		if($this->curPage<$this->cntPage){
			$next =  '<a href="'.$url.($this->curPage+1).'" class="next">下一页</a>';
			array_push($pagebar, $next);
		}
		
		
		return (implode('',$pagebar));
	}
	
}
/*
$cpage = isset($_GET['page'])?$_GET['page']:1;
$page = new PaginationHelper(12,2,$cpage);
$page->showPageMenu();
*/