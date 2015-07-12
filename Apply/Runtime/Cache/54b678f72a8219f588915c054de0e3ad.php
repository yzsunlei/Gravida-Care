<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <title>月子照护后台管理</title>
    <meta charset="UTF-8">
	<link href="__PUBLIC__/index/assets/css/block.css" rel="stylesheet" type="text/css" />
    <style type="text/css">

    </style>
</head>
<body>
<div class='dl-main'>
	<div class="dl-section dl-food">
		<h2>饮料列表</h2>
		<ul>
			<?php if(is_array($food)): $i = 0; $__LIST__ = $food;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><li>
				<p><img src="__PUBLIC__/index/Images/consume/<?php echo ($v["imgpath"]); ?>"/></p>
				<p><strong>名称</strong>：<?php echo ($v["name"]); ?></p>
				<p><strong>价格</strong>：￥<?php echo ($v["price"]); ?></p>
				<p><strong>功用</strong>：<?php echo ($v["remark"]); ?></p>
			</li><?php endforeach; endif; else: echo "" ;endif; ?>
		</ul>
	</div>
</div>
</body>
</html>