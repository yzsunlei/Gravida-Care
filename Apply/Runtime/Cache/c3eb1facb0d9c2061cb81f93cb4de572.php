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
	<div class="dl-section ">
		<h2>入住记录</h2>
		<table width='700px' border='1' cellspacing="0" cellpadding="0">
			<tr><td>id</td><td>姓名</td><td>房号</td><td>电话</td><td>护理师</td><td>费用</td><td>入住时间</td></tr>
		<?php if(is_array($gravida)): $i = 0; $__LIST__ = $gravida;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><tr><td><?php echo ($v["id"]); ?></td><td><?php echo ($v["name"]); ?></td><td><?php echo ($v["roomID"]); ?></td><td><?php echo ($v["tel"]); ?></td><td><?php echo ($v["serverID"]); ?></td><td>￥<?php echo ($v["money"]); ?></td><td><?php echo (date("Y-m-d H:m:s",$v["accesstime"])); ?></td></tr><?php endforeach; endif; else: echo "" ;endif; ?>
		</table>
	</div>
</div>
</body>
</html>