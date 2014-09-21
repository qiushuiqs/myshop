<?php



class CategoryModel extends Model{
	protected $table = 'category';
	
/*	//添加category
	public function add($data){
		$this->db->autoExecute($data, $this->table);
	}
*/	
	//获取本表下所有的数据
	public function getList(){
		$sql = "select cat_id, cat_name, dscrpt, parent_id from ".$this->table;
		return $this->db->getAll($sql);
	}
	/*
		getCatTree 找cate所有子栏目信息
		para: array $arr, 被查找的信息
			  int $id   需要列举的ID
			  int $lv=0 项目开头缩进
		return $id栏目的排序后的子孙列表
	*/
	public function getCatTree($arr, $id, $lv=0){
		$tree = array();
		
		foreach($arr as $v){
			if($v['parent_id'] == $id){
				$v['lv'] = $lv;
				$tree[] = $v;
				$tree= array_merge($tree, $this->getCatTree($arr, $v['cat_id'], $lv+1));
			}
			
		}
		return $tree;
	}
	/*
		getSon
		para: array $arr, 被查找的信息
			  int $id   需要列举的ID
		return $id栏目的排序后的子孙列表
	*/
	public function getSon($id){
		$sql ='select cat_id, cat_name, parent_id from '.$this->table.' where parent_id = '.$id;
		return $this->db->getAll($sql);
	}
	
	/*
		parm: 	array $arr, 被查找的信息
				int $id
		return array: $id栏目的家朴树
	*/
	public function getTree($arr,$id){
		$tree = array();
		while($id>0){
			foreach($arr as $v){
				if($v['cat_id']==$id){
					$tree[] = $v;
					$id = $v['parent_id'];
					break;
				}
			}
		}
		return array_reverse($tree);
	}
	
	//根据主键删除数据
	public function delete($id=0){
		$sql = "delete from ".$this->table." where cat_id = ".$id;
		$this->db->query($sql);
		
		return $this->db->affected_rows();
	}
	//根据主键 取出一行数据
	public function find($id){
		$sql = "select * from ".$this->table." where cat_id = ".$id;
		return $this->db->getRow($sql);
	}
	//根据主键 更新一行数据
	public function update($id,$data){
		$this->db->autoExecute($data,$this->table,'update',' where cat_id='.$id);
		return $this->db->affected_rows();
	}
}