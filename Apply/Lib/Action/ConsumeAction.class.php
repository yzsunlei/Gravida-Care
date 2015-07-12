<?php
// 本类由系统自动生成，仅供测试用途
class ConsumeAction extends Action {

	//饮料列表
    public function food(){
		$this->food = M('consume')->where('type=1')->select();
		$this->display('food');
    }
	
	//营养餐列表
    public function breakfast(){
		$this->breakfast = M('consume')->where('type=2')->select();
		$this->display('breakfast');
    }
	
	//消费记录列表
    public function Alist(){
		$this->Alist = M('message')->where('type=7')->order('time desc')->select();
		$this->display('list');
    }
	
	//添加消费分类
    public function add(){
		$this->display('add');
    }
	
	//确认添加消费分类
    public function confirmadd(){
		if($this->isPost()){
			//print_r($_POST);
			foreach($_POST as $v){
				if($v == ''){
					$this->error('请将表单信息填写完整！','add');
				}
			}
			$data = $_POST ;
			$action = M('consume')->add($data);
			$words = array("id"=>" ","words"=>"添加新消费类型成功！","time"=>date("Y-m-d H:i:s",time()),"type"=>"7");
			$message = M('message')->add($words);
			if($action and $message){
				$this->success('添加新消费类型成功！','food');
			}else{
				$this->error('添加新消费类型失败！','add');
			}
		}else{
			$this->error('非法操作！');
		}
    }
}