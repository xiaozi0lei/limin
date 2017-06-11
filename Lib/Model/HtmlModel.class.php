<?php

class HtmlModel extends Model {
	
	
	
	/**
	 * 更新制定类别的父类主页和列表页
	 * @param int $sid
	 */
	public function updateParentSortIndex($sid){
		$model=M('sort');
		$urls=array();
		$sort=$model->where(array('id'=>$sid))->find();
	
		if(empty($sort)||empty($sort['parent_id'])){
			return false;
		}
		$urls[]=U($sort['module'].'/index',array('sid'=>$sort['id']));
	
		$listcount=M($sort['module'])->where(array('sort'=>$sort['id']))->count();
	
		if($listcount>2){
			$urls[]=U($sort['module'].'/index',array('sid'=>$sort['id'],'p'=>1));
		}
	
		//查询父类
		$sub=$model->where(array('id'=>$sort['parent_id']))->find();
	
		if(!empty($sub['parent_id'])){
			$urls[]=U($sub['module'].'/index',array('sid'=>$sub['id']));
			$subcount=M($sub['module'])->where(array('sort'=>$sub['id']))->count();
			if($listcount>2){
				$urls[]=U($sub['module'].'/index',array('sid'=>$sub['id'],'p'=>1));
			}
			
			$three=$model->where(array('id'=>$sub['parent_id']))->find();
			$urls[]=U($three['module'].'/index',array('sid'=>$three['id']));
			
			$threecount=M($three['module'])->where(array('sort'=>$three['id']))->count();
			if($threecount>2){
				$urls[]=U($three['module'].'/index',array('sid'=>$three['id'],'p'=>1));
			}
		}
		return $urls;
	}
	

	/**
	 * 更新制定类别的父类主页和列表页
	 * @param int $sid
	 */
	public function updateSubSortIndex($sid){
		$model=M('sort');
		$urls=array();
		$sort=$model->where(array('id'=>$sid))->find();
	
		if(empty($sort)){
			return false;
		}
		$urls[]=U($sort['module'].'/index',array('sid'=>$sort['id']));
	
		$listcount=M($sort['module'])->where(array('sort'=>$sort['id']))->count();
	
		if($listcount>2){
			$urls[]=U($sort['module'].'/index',array('sid'=>$sort['id'],'p'=>1));
		}
	
		//查询父类
		$sub=$model->where(array('parent_id'=>$sort['id']))->find();
	
		if(!empty($sub['parent_id'])){
			$urls[]=U($sub['module'].'/index',array('sid'=>$sub['id']));
			$subcount=M($sub['module'])->where(array('sort'=>$sub['id']))->count();
			if($listcount>2){
				$urls[]=U($sub['module'].'/index',array('sid'=>$sub['id'],'p'=>1));
			}
				
			$three=$model->where(array('parent_id'=>$sub['id']))->find();
			$urls[]=U($three['module'].'/index',array('sid'=>$three['id']));
				
			$threecount=M($three['module'])->where(array('sort'=>$three['id']))->count();
			if($threecount>2){
				$urls[]=U($three['module'].'/index',array('sid'=>$three['id'],'p'=>1));
			}
		}
		return $urls;
	}
	
	
}
?>