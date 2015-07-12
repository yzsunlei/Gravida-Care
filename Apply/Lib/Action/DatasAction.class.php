<?php
// 数据库管理类
class DatasAction extends Action {
	//数据库列表
    public function index(){
		$this->display('list');
    }
	
	//数据库备份
	public function bak(){
		$db = M();
		$table = $db->query($sql = 'show tables');
		//print_r($table);
		$this->assign('table',$table);
		$this->display('bak');
    }
	
	//数据库导出操作
	public function out(){
		$db = M();
		$table = $db->query($sql = 'show tables');
		//print_r($table);
		$this->assign('table',$table);
		$this->display('out');
    }

	
}