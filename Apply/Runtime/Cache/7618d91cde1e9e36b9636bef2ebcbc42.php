<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html>
<head>
	<title>月子会所后台管理</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link href="__PUBLIC__/index/assets/css/block.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div class='dl-main'>
	<div class='dl-section'>
		<h2 class='msg'>消息记录</h2>
		<div class='dl_msg'>
			<ul>
			<?php if(is_array($message)): $i = 0; $__LIST__ = $message;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?><li><strong>时间</strong>：<?php echo (date("Y-m-d H:m:s",$item["time"])); ?>   <strong>消息</strong>：<?php echo ($item["words"]); ?></li><?php endforeach; endif; else: echo "" ;endif; ?>
			</ul>
		</div>
	</div>
	<div class="dl-alert"><?php echo ($alert); ?></div>
</div>
<script type="text/javascript" src="__PUBLIC__/index/js/jquery.js"></script>
<script type="text/javascript">
$('document').ready(function(){
	if($('.dl-alert').text() != ''){
		$('.dl-alert').fadeIn('normal');
	}
	setInterval(function(){
		//$('.dl-main').load('http://localhost/gravidacare/index.php/Status/message');
		$('.dl-main').load('message');
	},3000);
});
</script>
</body>
</html>