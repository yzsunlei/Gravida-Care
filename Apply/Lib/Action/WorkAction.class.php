<?php
// 业务管理类
class WorkAction extends Action {
	//业务办理初始页面
    public function index(){
		$this->show();
    }
	
	//孕妇入住列表
	public function Alist(){
		$gravida = M('gravida')->where('status > -1')->select();

		$this->gravida = $gravida;
		$this->display('list');
	}
	
	//孕妇历史入住记录
	public function Olist(){
		$gravida = M('gravida')->where('status = -1')->select();

		$this->gravida = $gravida;
		$this->display('olist');
	}	
	//孕妇入住
    public function add(){
		$rfid = M('rfid')->where('status = 0')->find();
		if($rfid){
			$this->assign('rfid',$rfid);
			$this->display('add');
		}else{
			$this->display('index');
		}
    }
	//确认入住
    public function confirmadd(){
		if($this->isPost()){
			$gravida = M('gravida')->where("rfid = '{$_POST[rfid]}' and status > -1")->find();
			if($gravida){
				$this->error('该卡对应的房间已有人入住！','money');
			}else{
				$data = $_POST;
				//判断提交的表单是否有空
				foreach($data as $value){
					if($value == ''){
						$this->error('请填写所有的表单项！','add');
					}
				}
				$data['id']="";
				$data['status']="0";
				$data['accesstime']=$data['updatetime']=time();
				//print_r($data);
				$gravida = M('gravida')->add($data);//将表单提交的数据信息插入gravida表，status=0
				$rfid_data['status'] = 1;
				$rfid = M('rfid')->where("id = '{$_POST[rfid]}'")->save($rfid_data);//将rfid表对应的rfid状态更新为1
				$words = array("id"=>" ","words"=>"新孕妇入住成功！","time"=>date("Y-m-d H:i:s",time()),"type"=>"5");
				$message = M('message')->add($words);
				if($gravida and $rfid and $message){
					$this->success('入住成功！','money');
				}else{
					$this->error('入住失败！','add');
				}
			}
			
		}else{
			$this->error('非法操作！');
		}
	
	}	
	//办理充值
    public function money(){
		$rfid = M('rfid')->where('status = 0')->find();
		if($rfid){
			$id = $rfid['id'];
			$gravida = M('gravida')->where("rfid='{$id}' and status > -1")->find();
			if($gravida){
				$this->assign('gravida',$gravida);
				$this->display('money');
			}else{
				$this->error('该卡尚未激活！','add');
			}
		}else{
			$this->display('index');
		}
    }
	//确认充值
    public function confirmmoney(){
		if ($this->isPost()){
			$gravida = M("gravida"); 
			$money = $gravida->where("rfid='{$_POST[rfid]}' and status != -1")->getField('money');//获取原有费用
			$data['money'] = $_POST['money'] + $money;//算出充值后的费用
			$action = $gravida->where("rfid='{$_POST[rfid]}'")->save($data);//进行充值操作
			$words = array("id"=>" ","words"=>"孕妇充值成功！","time"=>date("Y-m-d H:i:s",time()),"type"=>"5");
			$message = M('message')->add($words);
			if($action){
				$this->success('充值成功！');
			}else{
				$this->error('充值失败！');
			}
		}else{
			$this->error('非法操作！');
		}
	}

	//孕妇退房离开
    public function del(){
		$rfid = M('rfid')->where('status = 0')->find();
		if($rfid){
			$id = $rfid['id'];
			$gravida = M('gravida')->where("rfid='{$id}' and status > -1")->find();
			if($gravida){
				$this->assign('gravida',$gravida);
				$this->display('del');
			}else{
				$this->error('该卡尚未激活！','add');
			}
			
		}else{
			$this->display('index');
		}
    }
	//确认退房
    public function confirmdel(){
		if ($this->isPost()){
			//print_r($_POST);
			
			//直接将rfid对应孕妇的状态更改为-1
			//并且将rfid对应的卡的状态更改为-1
			$data['status'] = '-1';
			$gravida = M("gravida")->where("rfid = '{$_POST[rfid]}' and status > -1")->save($data); 
			$rfid = M("rfid")->where("id = '{$_POST[rfid]}'")->save($data); 
			$words = array("id"=>" ","words"=>"孕妇退房成功！","time"=>date("Y-m-d H:i:s",time()),"type"=>"5");
			$message = M('message')->add($words);
			if($gravida and $rfid and $message){
				$this->success('退房成功！');
			}else{
				$this->error('退房失败！');
			}
						
		}else{
			$this->error('非法操作！');
		}
	}
}