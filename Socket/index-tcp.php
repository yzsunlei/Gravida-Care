<?php
//调入数据库配置文件
require_once('config.php');
//调入数据库操作类
require_once('mysql.class.php');
//调入socket操作类
//require_once('socket.class.php');
//即使Client断开(如关掉浏览器)，PHP脚本也可以继续执行.

//实例化类
$mysql = new mysql($db_host, $db_user, $db_pwd, $db_database,'pconn', $db_charset);
mysql_query("set names 'utf8'");//写库 
//$socket = new socket();

ignore_user_abort(); 
//确保在连接客户端时不会超时
set_time_limit(0);
/*
 +-------------------------------
 *    @socket通信整个过程
 +-------------------------------
 *    @socket_create
 *    @socket_bind
 *    @socket_listen
 *    @socket_accept
 *    @socket_read
 *    @socket_write
 *    @socket_close
 +--------------------------------
 */

/*----------------    以下操作都是手册上的    -------------------*/
if(($sock = socket_create(AF_INET,SOCK_STREAM,SOL_TCP)) < 0) {
    echo "socket_create() failed reason:".socket_strerror($sock)."\n";
}

if(($ret = socket_bind($sock,$ip,$port)) < 0) {
    echo "socket_bind()  failed reason:".socket_strerror($ret)."\n";
}

if(($ret = socket_listen($sock,4)) < 0) {
    echo "socket_listen() failed reason:".socket_strerror($ret)."\n";
}

do {
    if (($msgsock = socket_accept($sock)) < 0) {
        echo "socket_accept() failed reason: " . socket_strerror($msgsock) . "\n";
        break;
    } else {

		$buf = socket_read($msgsock,8192);
		
		switch(substr($buf,0,3)){
			case 'ONN'://护士节点在线
				//echo "nurse online";
				$nurse = substr($buf,3,5);//取得护士的编号
				$rs = @mysql_query("UPDATE `nurse` SET `status` = 1 WHERE `servantID` ={$nurse} LIMIT 1");
				if($rs){
					$msg ="护士".$nurse."上线！\n";
					$sql="INSERT INTO `message`(`id`, `words`, `time`,`type`) VALUES(NULL, '$msg', CURRENT_TIMESTAMP,4)";
					$ms=mysql_query($sql);
					if($ms){
						$msg ="nurse ".$nurse." online\n";
						socket_write($msgsock, $msg, strlen($msg));
					}
				}else{
					$msg =time().":".$buf." no use\n";
					socket_write($msgsock, $msg, strlen($msg));
				}
				break;
				
			case 'ONP'://病人节点在线
				//echo "gravida online";
				$gravida = substr($buf,3,5);//取得病人的编号
				$rs = @mysql_query("UPDATE `gravida` SET `status` = 1 WHERE `homeID` ={$gravida} LIMIT 1");
				if($rs){
					$msg ="病人{$gravida}上线！\n";
					$sql="INSERT INTO `message`(`id`, `words`, `time`,`type`) VALUES(NULL, '$msg', CURRENT_TIMESTAMP,4)";
					$ms=mysql_query($sql);
					if($ms){
						$msg ="gravida ".$gravida." online\n";
						socket_write($msgsock, $msg, strlen($msg));
					}
				}else{
					$msg =time().":".$buf." no use";
					socket_write($msgsock, $msg, strlen($msg));
				}
				break;
				
			case 'ONR'://路由器节点在线，暂留
				//echo "server online";
				break;
				
			case 'LOP'://病人低电量报警
				//echo "gravida power off";
				$gravida = substr($buf,3,5);//取得病人节点
				$msg ="病人节点{$gravida}低电量报警\n";
				$sql="INSERT INTO `message`(`id`, `words`, `time` ,`type`) VALUES(NULL, '$msg', CURRENT_TIMESTAMP,2)";
				$ms=mysql_query($sql);
				if($ms){
					$msg ="gravida ".$gravida." power off\n";
					socket_write($msgsock, $msg, strlen($msg));
				}else{
					$msg =time().":".$buf." no use\n";
					socket_write($msgsock, $msg, strlen($msg));
				}
				break;
				
			case 'LON'://护士低电量报警
				//echo "nurse power off";
				$nurse = substr($buf,3,5);//取得病人节点
				$msg ="护士节点{$nurse}低电量报警\n";
				$sql="INSERT INTO `message`(`id`, `words`, `time` ,`type`) VALUES(NULL, '$msg', CURRENT_TIMESTAMP , 2)";
				$ms=mysql_query($sql);
				if($ms){
					$msg ="nurse ".$nurse." power off\n";
					socket_write($msgsock, $msg, strlen($msg));
				}else{
					$msg =time().":".$buf." no use\n";
					socket_write($msgsock, $msg, strlen($msg));
				}
				break;
				
			case 'CAL'://病人呼叫请求
				//echo "gravida call";
				$gravida = substr($buf,3,5);//取得病人的编号
				$msg ="病人{$gravida}发出呼叫请求\n";
				$sql="INSERT INTO `message`(`id`, `words`, `time` ,`type`) VALUES(NULL, '$msg', CURRENT_TIMESTAMP ,1)";
				$ms=mysql_query($sql);
				if($ms){
					$msg ="gravida ".$gravida." call\n";
					socket_write($msgsock, $msg, strlen($msg));
				}else{
					$msg =time().":".$buf." no use\n";
					socket_write($msgsock, $msg, strlen($msg));
				}
				break;
				
			case 'CAN'://病人取消呼叫请求
				//echo "gravida cancel call";
				$gravida = substr($buf,3,5);//取得病人的编号
				$msg ="病人{$gravida}取消呼叫请求\n";
				$sql="INSERT INTO `message`(`id`, `words`, `time` ,`type`) VALUES(NULL, '$msg', CURRENT_TIMESTAMP , 1)";
				$ms=mysql_query($sql);
				if($ms){
					$msg ="gravida ".$gravida." cancle call\n";
					socket_write($msgsock, $msg, strlen($msg));
				}else{
					$msg =time().":".$buf." no use\n";
					socket_write($msgsock, $msg, strlen($msg));
				}
				break;
				
			case 'CON'://护士确认服务
				//echo "nurse confirm serve";
				$gravida = substr($buf,3,5);//取得病人的编号
				$msg ="病人{$gravida}已确认服务\n";
				$sql="INSERT INTO `message`(`id`, `words`, `time` ,`type`) VALUES(NULL, '$msg', CURRENT_TIMESTAMP,1)";
				$ms=mysql_query($sql);
				if($ms){
					$msg ="gravida ".$gravida." confirm service\n";
					socket_write($msgsock, $msg, strlen($msg));
				}else{
					$msg =time().":".$buf." no use\n";
					socket_write($msgsock, $msg, strlen($msg));
				}				
				break;
				
			case 'EVA'://评价操作
				//echo "gravida assess";
				$nurse = substr($buf,3,2);//取得评价护士的编号
				if(substr($buf,5,3) == 'GOD'){
					$word = "好评";
					$grade= 2 ;
				}else if(substr($buf,5,3) == 'MED'){
					$word = "中评";
					$grade= 1 ;
				}else if(substr($buf,5,3) == 'BAD'){
					$word = "差评";
					$grade= 0 ;
				}else{
					$word = "取消";
				}
				$msg ="护士{$nurse}获得评价：{$word}\n";
				//插入消息表message
				$sql="INSERT INTO `message`(`id`, `words`, `time`,`type`) VALUES(NULL, '$msg', CURRENT_TIMESTAMP ,3)";
				$ms=mysql_query($sql);
				if($word == "取消"){
					//更新评价记录表evaluate
					//$sql="INSERT INTO `evaluate`(`id`, `time`, `servantID`, `assess`) VALUES(NULL, CURRENT_TIMESTAMP, '$nurse' ,'$grade')";
					//$mz=mysql_query($sql);
				}else{
					//插入评价记录表evaluate
					$sql="INSERT INTO `evaluate`(`id`, `time`, `servantID`, `assess`) VALUES(NULL, CURRENT_TIMESTAMP, '$nurse' ,'$grade')";
					$mz=mysql_query($sql);
				}
				if($ms && $mz){
					$msg ="nurse ".$nurse." get praise".substr($buf,5,3)."\n";
					socket_write($msgsock, $msg, strlen($msg));
				}else{
					$msg =time().":".$buf." no use\n";
					socket_write($msgsock, $msg, strlen($msg));
				}				
				break;	
				
			case 'TEM'://温度记录  假设温度信号ONN00001变量#
			
				break;
				
			default :
				$msg =time().":".$buf." no use\n";
				socket_write($msgsock, $msg, strlen($msg));
				break;
		}
		
	 	//更新护士节点的状态
	 	$nurse = $mysql->select('nurse');
		while($nurse=$mysql->fetch_assoc()){
			if( ($now = time()) - $nurse['updatetime'] > 30){
				$rs = @mysql_query("UPDATE `nurse` SET `status` = 0 ,`updatetime` ={$now}  WHERE `servantID` = {$nurse['servantID']} LIMIT 1");
				if($rs){
					//$msg =$now.":nurse ".$nurse['servantID']." offline\n";
					//socket_write($msgsock, $msg, strlen($msg));
				}else{
					$msg =$now.":".$nurse['servantID']." no use\n";
					socket_write($msgsock, $msg, strlen($msg));
				}
			}
		}
     
		//更新病人节点的状态
	 	$gravida = $mysql->select('gravida');
		while($gravida=$mysql->fetch_assoc()){
			if( ($now = time()) - $gravida['updatetime'] > 30){
				$rs = @mysql_query("UPDATE `gravida` SET `status` = 0 ,`updatetime` ={$now}  WHERE `homeID` ={$gravida['homeID']} LIMIT 1 ");
				if($rs){
					//$msg =$now.":gravida ".$gravida['homeID']." offline\n";
					//socket_write($msgsock, $msg, strlen($msg));
				}else{
					$msg =$now.":".$gravida['homeID']."no use";
					socket_write($msgsock, $msg, strlen($msg));
				}
			}
		}
     
    }
	
    socket_close($msgsock);
	sleep(20);
} while(true);

socket_close($sock);
?>