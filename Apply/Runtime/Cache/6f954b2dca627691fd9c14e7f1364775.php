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
	<h2>护理列表</h2>
	<?php if(is_array($servant)): $i = 0; $__LIST__ = $servant;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?><div class='dl_servant'>
			<a href="<?php echo U('Status/showservant');?>/serverID/<?php echo ($item["serverID"]); ?>"  onclick="showServant(this.href);return false;"><img src="__PUBLIC__/index/Images/nurse_<?php switch($item["status"]): case "1": ?>online<?php break; default: ?>offline<?php endswitch;?>.png"/></a>
			<p>编号：<?php echo ($item["serverID"]); ?></p>
			<p>姓名：<?php echo ($item["name"]); ?></p>
			<p>状态：<?php echo ($item['status']?'在线':'离线'); ?></p>
		</div><?php endforeach; endif; else: echo "" ;endif; ?>
	</div>
</div>
<div class="dl-alert"><?php echo ($alert); ?></div>
<div class="dl-mask"><!--隐藏的遮罩层-->
	<div class="dl-show-servant">
		#
	</div>
</div>
<script type="text/javascript" src="__PUBLIC__/index/js/jquery.js"></script>
<script type="text/javascript">
$('document').ready(function(){
	if($('.dl-alert').text() != ''){
		$('.dl-alert').fadeIn('normal');
	}
	setInterval(function(){
		//$('.dl-main').load('http://localhost/gravidacare/index.php/Status/servant');
		$('.dl-main').load('servant');
	},3000);
});

function showServant(href){ //显示护士信息
	$('.dl-mask').show();
	$('.dl-show-servant').load(href);
	$('.dl-show-servant').show();
}

function closeMask(){ //关闭弹出信息
	$('.dl-mask').hide();
	$('.dl-show-gravida').hide();
	$('.dl-show-servant').hide();
}
</script>
</body>
</html>