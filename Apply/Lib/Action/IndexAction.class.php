<?php
// 系统首页类
class IndexAction extends CommonAction {
    public function index(){
		$this->assign('username',$_SESSION['username']);
		$this->display();
    }
	public function logout(){
		SESSION(null);
		$this->success('成功退出！','__ROOT__/index.php/Login');
	}
	
}