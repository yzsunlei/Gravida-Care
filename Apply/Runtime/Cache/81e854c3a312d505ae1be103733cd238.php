<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <title>月子照护后台管理</title>
    <meta charset="UTF-8">
	<link href="__PUBLIC__/index/assets/css/block.css" rel="stylesheet" type="text/css" />
    <style type="text/css">
		table{margin:15px auto;border:1px solid #ccc;text-align:center}
		td{padding:5px;}
    </style>
</head>
<body>
<div class='dl-main'>
	<div class="dl-section">
		<h2>排班管理</h2>
		<div class="dl-checkin">
			<table width='400px' border='1' cellspacing="0" cellpadding="0" style="margin:15px auto;border:1px solid #ccc;text-align:center">
				<tr><td colspan="2">今日护理师工作列表</td></tr>
				<tr><td>姓名</td><td>护理ID / 状态</td></tr>
				<?php if(is_array($servant)): $i = 0; $__LIST__ = $servant;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?><tr><td><?php echo ($item["name"]); ?></td><td><?php echo ($item["serverID"]); ?> / 状态:<?php echo ($item['status']?'下班中':'值班中'); ?></td></tr><?php endforeach; endif; else: echo "" ;endif; ?>
			</table>
		</div>
	</div>
</div>
</body>
</html>