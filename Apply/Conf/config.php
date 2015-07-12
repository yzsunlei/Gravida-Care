<?php
//项目配置文件
return array(
	'URL_ROUTER_ON'      => true, //URL路由
    'URL_MODEL'          => '1', //URL模式
    'SESSION_AUTO_START' => true, //是否开启session
    'USER_CONFIG'        => array(
        'USER_AUTH' => true,
        'USER_TYPE' => 2,
    ),
	'URL_HTML_SUFFIX'    =>'',

    //数据库配置
	'DB_TYPE'=>'mysql',
	'DB_HOST'=>'127.0.0.1',
	'DB_NAME'=>'gravidacare',
	'DB_USER'=>'root',
	'DB_PWD'=>'123456',
	'DB_PORT'=>'3306',
	'DB_PREFIX'=>'',
	
	//跳转页面设置
	//默认错误跳转对应的模板文件
	'TMPL_ACTION_ERROR' => 'Public:error',
	//默认成功跳转对应的模板文件
	'TMPL_ACTION_SUCCESS' => 'Public:success',
);
?>