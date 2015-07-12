<?php
// 值班管理类
class DutyAction extends Action {
    public function index(){
		$this->show();
    }
	
	//今日值班表
	public function Alist(){
		$this->servant = M('servant')->order('serverID')->select();
		$this->display('Alist');
	}
	
	//添加值班表
	public function addlist(){
		$this->servant = M('schedual')->where('status = 1')->order('date desc')->select();
		$this->display('addlist');
	}

	//确定添加值班表
	public function confirmaddlist(){
		print_r($_POST);
	}
	
	public function leave(){
		$this->leaveName = M('servant')->where('status > -1')->select();
		$this->replaceName = M('servant')->where('status = -1')->select();
		$this->display('leave');
	}
	
	public function confirmleave(){
		if($this->isPost()){
			//print_r($_POST);
			$data['status'] = -1;
			$action1 = M('servant')->where("name = '$_POST[leaveName]'")->save($data);
			$data['status'] = 0;
			$action2 = M('servant')->where("name = '$_POST[replaceName]'")->save($data);
			$words = array("id"=>" ","words"=>"护理师请假成功！","time"=>date("Y-m-d H:i:s",time()),"type"=>"5");
			$message = M('message')->add($words);
			if($action1 and $action2 and $message){
				$this->success('请假成功！','servant');
			}else{
				$this->error('请假失败！','leave');
			}
		}else{
			$this->error('非法操作！');
		}
	}
	
	public function confirmadd(){
		if($this->isPost()){
			//print_r($_POST);
			foreach($_POST as $v){
				if($v == ''){
					$this->error('请将表单信息填写完整！','add');
				}
			}
			$data = $_POST ;
			$data['comment'] = 0;
			$data['status'] = '-1';
			$data['updatetime'] = time();
			//print_r($data);
			$action = M('servant')->add($data);
			$words = array("id"=>" ","words"=>"添加新职员成功！","time"=>date("Y-m-d H:i:s",time()),"type"=>"5");
			$message = M('message')->add($words);
			if($action and $message){
				$this->success('添加新职员成功！','servant');
			}else{
				$this->error('添加新职员失败！','add');
			}
		}else{
			$this->error('非法操作！');
		}
	}
}