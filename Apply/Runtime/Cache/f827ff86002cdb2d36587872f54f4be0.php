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
	<h2 name='pregnant'>孕妇列表</h2>
	<?php if(is_array($gravida)): $i = 0; $__LIST__ = $gravida;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?><div class='dl_servant'>
			<a href="<?php echo U('Status/showgravida');?>/roomID/<?php echo ($item["roomID"]); ?>" onclick="showGravida(this.href);return false;"><img src="__PUBLIC__/index/Images/patient_<?php switch($item["status"]): case "10": ?>call<?php break; case "1": ?>online<?php break; default: ?>offline<?php endswitch;?>.png"/></a>
			<p>房号：<?php echo ($item["roomID"]); ?></p>
			<p>姓名：<?php echo ($item["name"]); ?></p>
			<p>状态：<?php switch($item["status"]): case "10": ?>呼叫<?php break; case "1": ?>在线<?php break; default: ?>离线<?php endswitch;?></p>
		</div><?php endforeach; endif; else: echo "" ;endif; ?>
	</div>
	<div class="dl-alert"><?php echo ($alert); ?></div>
</div>

<div class="dl-mask"><!--隐藏的遮罩层-->
	<div class="dl-show-gravida">
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
		//$('.dl-main').load('http://localhost/gravidacare/index.php/Status/gravida/id/1');
		$('.dl-main').load('gravida');
	},3000);
});

function showGravida(href){ //显示孕妇信息
	$('.dl-mask').show();
	$('.dl-show-gravida').load(href);
	$('.dl-show-gravida').show();
}

function closeMask(){ //关闭弹出信息
	$('.dl-mask').hide();
	$('.dl-show-gravida').hide();
	$('.dl-show-servant').hide();
}
</script>
</body>
</html>