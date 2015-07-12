<?php
// 系统公共类
class CommonAction extends Action {
	//判断是否登录
	Public function _initialize(){
		if(!isset($_SESSION['uid'])){
			$this->redirect('Login/index');
		}
	}	
}