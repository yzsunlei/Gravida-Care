<?php
// 状态监控类
class StatusAction extends Action {
	//默认获取孕妇状态
    public function gravida(){
		$gravida = M('gravida')->where('status > -1')->select();
		$this->assign("gravida",$gravida);
		
		$alert = M('message')->order('time desc')->find();
		if($alert['type']== 1){
			$this->assign("alert","呼叫消息：".$alert['words']);
		}else if($alert['type']== 2){
			$this->assign("alert","报警消息：".$alert['words']);
		}
		$this->display('gravida');
    }
	
	//获取护士状态
    public function servant(){
		$servant = M('servant')->where('status > -1')->select();
		$this->assign("servant",$servant);
		
		$alert = M('message')->order('time desc')->find();
		if($alert['type']== 1){
			$this->assign("alert","呼叫消息：".$alert['words']);
		}else if($alert['type']== 2){
			$this->assign("alert","报警消息：".$alert['words']);
		}
		$this->display('servant');
    }

	//默认消息状态
    public function message(){
		$message = M('message')->order('time desc')->select();

		$this->assign("message",$message);
		
		$this->display('message');
    }
	
	//获取单个孕妇详细信息 参数roomID
	public function showgravida(){
		$roomID = $this->_param('roomID'); 
		$gravida = M('gravida')->where("roomID={$roomID}")->find();

		$curtemp = M('humiture')->where("roomID={$roomID} and type=1")->order('time desc')->find();
		$curhumi = M('humiture')->where("roomID={$roomID} and type=2")->order('time desc')->find();
	
		$gravida['curtemp'] = $curtemp['value'] ;
		$gravida['curhumi'] = $curhumi['value'] ;
		$this->assign('item',$gravida);//输出孕妇基本参数
		
		$temp = M('humiture')->where("roomID={$roomID} and type=1")->order('time desc')->limit(7)->select();
		$humi = M('humiture')->where("roomID={$roomID} and type=2")->order('time desc')->limit(7)->select();
		$this->assign('temp',$temp);//输出孕妇近七次温度
		$this->assign('humi',$humi);//输出孕妇近七次湿度
		
		$this->display('showgravida');
	}
	
	//获取单个护士详细信息 参数serverID
    public function showservant(){
		$serverID = $this->_param('serverID'); 
		$servant = M('servant')->where("serverID={$serverID}")->find();
		$belong = M('gravida')->where("serverID={$serverID}")->select();
		foreach ($belong as $v){
			$duty = $v['roomID'].','.$duty;
		}		
		$servant['duty'] = rtrim($duty, ",")? rtrim($duty, ",") : '暂无' ;//输出护士服务房号
		$this->assign('item',$servant);//输出护士基本参数
		
		$praise = M('praise') -> where("serverID={$serverID}")->order('time desc')->limit(7)->select();
		$this->assign('praise',$praise);//输出护士近七次评分
		
		$praises = M('praise') -> where("serverID={$serverID}")->select();
		foreach ($praises as $v){
			$praiseAll = $v['grade'] + $praiseAll ; 
		}	
		$this->assign('praiseAll',$praiseAll);//输出护士总评分
		
		$this->display('showservant');
	}
}