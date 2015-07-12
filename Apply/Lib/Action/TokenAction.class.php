<?php
// APP接口类
class TokenAction extends Action {
    public function status(){  //状态接口
		if($_GET[_URL_][2] == 'gravida'){
			if($_GET[_URL_][3]){
				$serverID = $_GET[_URL_][3];
				$gravida = M('gravida')->where("status > -1 and serverID ={$serverID}")->getField('name,roomID,serverID,status,temperature,humidity');
			
			}else{
				$gravida = M('gravida')->where('status > -1')->getField('name,roomID,serverID,status,temperature,humidity');
			}
			foreach($gravida as $v){
				$gravidaInfo['gravida'][] = $v;
			}
			echo json_encode($gravidaInfo);
		}else if($_GET[_URL_][2] == 'message'){
			$start = $_GET[_URL_][3];
			$offset = $_GET[_URL_][4];
			//$message = M('message')->order('time desc')->select();
			$message = M('message')->order('time desc')->limit("{$start},{$offset}")->select();
			foreach($message as $v){
				$messageInfo['message'][] = $v;
			}
			echo json_encode($messageInfo);
		}else if($_GET[_URL_][2] == 'servant'){
			$servant = M('servant')->where('status > -1')->getField('name,serverID,status');
			foreach($servant as $v){
				$servantInfo['servant'][] = $v;
			}
			echo json_encode($servantInfo);
		}else{
			echo '访问出错！';
		}
    }

    public function consume(){  //消费接口
		if($_GET[_URL_][2] == 'food'){//饮料列表
			$food = M('consume')->where('type = 1')->select();
			foreach($food as $v){
				$foodInfo['food'][] = $v;
			}
			echo json_encode($foodInfo);
		}else if($_GET[_URL_][2] == 'breakfast'){//早餐列表
			$breakfast = M('consume')->where('type = 2')->select();
			foreach($breakfast as $v){
				$breakfastInfo['breakfast'][] = $v;
			}
			echo json_encode($breakfastInfo);
		}else if($_GET[_URL_][2] == 'consume'){
			$start = $_GET[_URL_][3];
			$offset = $_GET[_URL_][4];
			$message = M('message')->where('type=7')->order('time desc')->limit("{$start},{$offset}")->select();
			foreach($message as $v){
				$messageInfo['message'][] = $v;
			}
			echo json_encode($messageInfo);
		}else{
			echo "访问出错！";
		}
	}
}