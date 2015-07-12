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
		<h2>数据库备份</h2>
		<div class="dl-checkin">
			<table width='400px' border='1' cellspacing="0" cellpadding="0" style="margin:15px auto;border:1px solid #ccc;text-align:center">
			<tr><td colspan="2">所有数据表</td></tr>
			<?php if(is_array($table)): $i = 0; $__LIST__ = $table;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?><tr><td colspan="2"><?php echo ($item['Tables_in_gravidacare']); ?></td></tr><?php endforeach; endif; else: echo "" ;endif; ?>
			<tr><td colspan="2"><input type="submit" value="确定备份"/></td></tr>
			</table>
		</div>
	</div>
</div>
</body>
</html>