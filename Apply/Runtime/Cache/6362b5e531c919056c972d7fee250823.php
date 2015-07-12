<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html>
 <head>
  <title>月子会所后台管理</title>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
   <link href="__PUBLIC__/index/assets/css/dpl-min.css" rel="stylesheet" type="text/css" />
  <link href="__PUBLIC__/index/assets/css/bui-min.css" rel="stylesheet" type="text/css" />
   <link href="__PUBLIC__/index/assets/css/main.css" rel="stylesheet" type="text/css" />
 </head>
 <body>

  <div class="header">
    
      <div class="dl-title">
       月子会所后台管理
      </div>

    <div class="dl-log">欢迎您，<span class="dl-log-user"><?php echo ($username); ?></span><a href="<?php echo U('Index/logout');?>" title="退出系统" class="dl-log-quit">[退出]</a>
    </div>
  </div>
   <div class="content">
    <div class="dl-main-nav">
      <div class="dl-inform"><div class="dl-inform-title"><s class="dl-inform-icon dl-up"></s></div></div>
      <ul id="J_Nav"  class="nav-list ks-clear">
				<li class="nav-item dl-selected"><div class="nav-item-inner nav-status">状态监控</div></li>       
				<li class="nav-item dl-selected"><div class="nav-item-inner nav-work">业务管理</div></li>       
				<li class="nav-item dl-selected"><div class="nav-item-inner nav-duty">值班管理</div></li>       
				<li class="nav-item dl-selected"><div class="nav-item-inner nav-consume">消费管理</div></li>       
				<li class="nav-item dl-selected"><div class="nav-item-inner nav-role">权限管理</div></li>       
				<li class="nav-item dl-selected"><div class="nav-item-inner nav-datas">数据库管理</div></li>       
      </ul>
    </div>
    <ul id="J_NavContent" class="dl-tab-conten">

    </ul>
   </div>
  <script type="text/javascript" src="__PUBLIC__/index/assets/js/jquery-1.8.1.min.js"></script>
  <script type="text/javascript" src="__PUBLIC__/index/assets/js/bui-min.js"></script>
  <script type="text/javascript" src="__PUBLIC__/index/assets/js/common/main-min.js"></script>
  <script type="text/javascript" src="__PUBLIC__/index/assets/js/config-min.js"></script>
  <script>
    BUI.use('common/main',function(){
      var config = [{id:'1',homePage : '1',menu:[{text:'状态监控',items:[{id:'1',text:'孕妇状态',href:'Status/gravida'},{id:'2',text:'护理师状态',href:'Status/servant'},{id:'3',text:'消息状态',href:'Status/message'}]}]},
	                {id:'2',homePage : '1',menu:[{text:'业务管理',items:[{id:'1',text:'入住列表',href:'Work/Alist'},{id:'2',text:'历史入住',href:'Work/Olist'},{id:'3',text:'孕妇入住',href:'Work/add'},{id:'4',text:'办理充值',href:'Work/money'},{id:'5',text:'退房离开',href:'Work/del'}]}]},
					{id:'3',homePage : '1',menu:[{text:'值班管理',items:[{id:'1',text:'今日值班表',href:'Duty/Alist'},{id:'2',text:'护理师排班',href:'Duty/addlist'},{id:'3',text:'护理师请假',href:'Duty/leave'},{id:'4',text:'添加护理师',href:'Duty/add'}]}]},
					{id:'4',homePage : '1',menu:[{text:'消费管理',items:[{id:'1',text:'饮料分类',href:'Consume/food'},{id:'2',text:'营养餐分类',href:'Consume/breakfast'},{id:'3',text:'添加消费分类',href:'Consume/add'},{id:'4',text:'消费信息记录',href:'Consume/Alist'}]}]},
					{id:'5',homePage : '1',menu:[{text:'权限管理',items:[{id:'1',text:'管理列表',href:'Role/list'},{id:'2',text:'添加管理',href:'Role/add'},{id:'3',text:'编辑权限',href:'Role/edit'}]}]},
					{id:'6',homePage : '1',menu:[{text:'数据库管理',items:[{id:'1',text:'数据库备份',href:'Datas/bak'},{id:'2',text:'数据库导出',href:'Datas/out'}]}]}];
      new PageUtil.MainPage({
        modulesConfig : config
      });
    });
  </script>
 </body>
</html>