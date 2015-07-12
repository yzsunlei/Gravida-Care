<?php
// 后台用户登录类
class LoginAction extends Action {
    public function index(){
		$this->show();
    }
    public function check(){
		$db=M('manage');
		$user = $db->where(array('nickname' =>I('username')))->find();
		if(!$user || $user['pwd'] != I('password','','md5')){
			$this->error('账户或密码错误！');
		}else{
			//登录成功后写入session
			session('uid',$user['id']);
			session('username',$user['nickname']);
			//session('logintime',date('Y-m-d H:i:s',$user['logintime']));	
			//登录成功跳转后台首页
			$this->success('登录成功！正在跳转..','__ROOT__/index.php/');
		}
    }
}