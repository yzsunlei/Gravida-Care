<?php
//调入数据库配置文件
require_once('config.php');
//调入数据库操作类
require_once('mysql.class.php');
//即使Client断开(如关掉浏览器)，PHP脚本也可以继续执行.

//实例化类
$mysql = new mysql($db_host, $db_user, $db_pwd, $db_database,'pconn', $db_charset);
mysql_query("set names 'utf8'");//写库 

//error_reporting( E_ALL );
set_time_limit( 0 );
ob_implicit_flush();
$socket = socket_create( AF_INET, SOCK_DGRAM, SOL_UDP );
if ( $socket === false ) {
    echo "socket_create() failed:reason:" . socket_strerror( socket_last_error() ) . "\n";
}
$ok = socket_bind( $socket, $ip , $port );
if ( $ok === false ) {
    echo "socket_bind() failed:reason:" . socket_strerror( socket_last_error( $socket ) );
}
while ( true ) {

    socket_recvfrom( $socket, $buf , 1024, 0, $from, $port );
	
	switch(substr($buf,0,3)){
			case 'ONN'://护理师节点在线
				$nurse = substr($buf,3,5);//取得护理师的编号
				$online =mysql_query("select * from `servant` WHERE `serverID` ='$nurse' and status >= 1 LIMIT 1 ");
				$row=mysql_fetch_array($online);
				$time = time();
				if(!is_array($row)){ //如果不在线，更新servant的状态和时间
					$rs = mysql_query("UPDATE `servant` SET `status` = 1 ,`updatetime` ='$time' WHERE `serverID` ='$nurse' LIMIT 1");
					if($rs){
						$msg ="护理师".$nurse."上线！\n";
						$sql="INSERT INTO `message`(`id`, `words`, `time`,`type`) VALUES(NULL, '$msg', '$time',6)";
						$ms=mysql_query($sql);
						if($ms){
							$msg ="nurse ".$nurse." online\n";
							echo $msg;
						}
					}else{
						$msg =date("Y-m-d H:i:s",time())." : signal ".$buf." is lost\n";
						echo $msg;
					}
				}else{   //如果在线只更新servant的时间
					@mysql_query("UPDATE `servant` SET `updatetime` = '$time' WHERE `serverID` ='$nurse' LIMIT 1");
				}
				break;
				
			case 'ONP'://孕妇节点在线
				$gravida = substr($buf,3,5);//取得孕妇的编号
				$online =@mysql_query("select * from `gravida` WHERE `roomID` ={$gravida} and status >= 1 LIMIT 1 ");
				$row=@mysql_fetch_array($online);
				$time = time();
				if(!is_array($row)){
					$rs = @mysql_query("UPDATE `gravida` SET `status` = 1 ,`updatetime` ='$time' WHERE `roomID` ={$gravida} LIMIT 1");
					if($rs){					
						$msg ="孕妇{$gravida}上线！\n";
						$sql="INSERT INTO `message`(`id`, `words`, `time`,`type`) VALUES(NULL, '$msg',  ".time().",6)";
						$ms=mysql_query($sql);
						if($ms){
							$msg ="gravida ".$gravida." online\n";
							echo $msg;
						}					
					}else{
						$msg =date("Y-m-d H:i:s",time())." : signal ".$buf." is lost\n";
						echo $msg;
					}
				}else{
					mysql_query("UPDATE `gravida` SET `updatetime` = '$time' WHERE `roomID` ={$gravida} LIMIT 1");
				}
				break;
				
			case 'ONR'://路由器节点在线，暂留
				//echo "server online";
				break;
				
			case 'LOP'://孕妇节点低电量报警
				$gravida = substr($buf,3,5);//取得孕妇节点
				$msg ="孕妇节点{$gravida}低电量报警\n";
				$sql="INSERT INTO `message`(`id`, `words`, `time` ,`type`) VALUES(NULL, '$msg',  ".time().",2)";
				$ms=mysql_query($sql);
				if($ms){
					$msg ="gravida ".$gravida." power off\n";
					echo $msg;
				}else{
					$msg =date("Y-m-d H:i:s",time())." : signal ".$buf." is lost\n";
					echo $msg;
				}
				break;
				
			case 'LON'://护士低电量报警
				$servant = substr($buf,3,5);//取得护士节点
				$msg ="护士节点{$servant}低电量报警\n";
				$sql="INSERT INTO `message`(`id`, `words`, `time` ,`type`) VALUES(NULL, '$msg',  ".time()." , 2)";
				$ms=mysql_query($sql);
				if($ms){
					$msg ="servant ".$servant." power off\n";
					echo $msg;
				}else{
					$msg =date("Y-m-d H:i:s",time())." : signal ".$buf." is lost\n";
					echo $msg;
				}
				break;
				
			case 'CAL'://孕妇呼叫请求
				$gravida = substr($buf,3,5);//取得病人的编号
				$rs = @mysql_query("UPDATE `gravida` SET `status` = 10 WHERE `roomID` ={$gravida} LIMIT 1");
				$msg ="孕妇{$gravida}发出呼叫请求\n";
				$time =time() ;
				$ms = mysql_query("INSERT INTO `message`(`id`, `words`, `time` ,`type`) VALUES(NULL, '$msg', '$time' ,1)");
				
				if($rs and $ms){
					$msg ="gravida ".$gravida." is calling\n";
					echo $msg;
				}else{
					$msg =date("Y-m-d H:i:s",time())." : signal ".$buf." is lost\n";
					echo $msg;
				}
				break;
				
			case 'CAN'://孕妇取消呼叫请求
				$gravida = substr($buf,3,5);//取得孕妇的编号
				$rs = @mysql_query("UPDATE `gravida` SET `status` = 1 WHERE `roomID` ={$gravida} LIMIT 1");
				$msg ="病人{$gravida}取消呼叫请求\n";
				$time = time();
				$ms=mysql_query("INSERT INTO `message`(`id`, `words`, `time` ,`type`) VALUES(NULL, '$msg',  '$time' , 1)");
				if($ms and $rs){
					$msg ="gravida ".$gravida." cancle called\n";
					echo $msg;
				}else{
					$msg =date("Y-m-d H:i:s",time())." : signal ".$buf." is lost\n";
					echo $msg;
				}
				break;
				
			case 'CON'://护士确认服务
				$gravida = substr($buf,3,5);//取得孕妇的编号
				$rs = @mysql_query("UPDATE `gravida` SET `status` = 1 WHERE `roomID` ={$gravida} LIMIT 1");
				$msg ="病人{$gravida}已确认服务\n";
				$time = time();
				$ms=mysql_query("INSERT INTO `message`(`id`, `words`, `time` ,`type`) VALUES(NULL, '$msg', '$time',4)");
				if($ms and $rs){
					$msg ="gravida ".$gravida." confirm service\n";
					echo $msg;
				}else{
					$msg =date("Y-m-d H:i:s",time())." : signal ".$buf." is lost\n";
					echo $msg;
				}				
				break;
				
			case 'EVA'://评价操作
				$nurse = substr($buf,3,2);//取得评价对应护士的编号
				if(substr($buf,5,3) == 'GOD'){
					$word = "好评";
					$grade= 1 ;
				}else if(substr($buf,5,3) == 'MED'){
					$word = "中评";
					$grade= 0 ;
				}else if(substr($buf,5,3) == 'BAD'){
					$word = "差评";
					$grade= -1 ;
				}else{
					$word = "取消";
				}
				$msg ="护士{$nurse}获得评价：{$word}\n";
				$sql="INSERT INTO `message`(`id`, `words`, `time`,`type`) VALUES(NULL, '$msg', ".time()." ,3)";
				$ms=mysql_query($sql);
				if($word == "取消"){
					//取消评价暂留
				}else{
					$time = time();
					$mz=mysql_query("INSERT INTO `praise`(`id`, `serverID`, `grade`,`time`) VALUES(NULL, '$nurse' ,'$grade' , '$time')");
				}
				if($ms && $mz){
					$msg ="nurse ".$nurse." get praise ".substr($buf,5,3)."\n";
					echo $msg;
				}else{
					$msg =date("Y-m-d H:i:s",time())." : signal ".$buf." is lost\n";
					echo $msg;
				}				
				break;	
								
			case '$E0'://温湿度记录 
				$hum = substr($buf,4,2);
				$tem = substr($buf,7,2);
				$time = time();
				for($a = 1 ;$a < 3 ;$a++ ){
					for($b = 1;$b < 3;$b++){
						$roomID = '0'.$a.'00'.$b;
						$ms = mysql_query("INSERT INTO `humiture`(`id`, `type`,`value`, `time` ,`roomID`) VALUES (NULL, '1' , '$tem','$time','$roomID'),(NULL, '2' , '$hum','$time','$roomID')");
						$rs = mysql_query("update `gravida` set `temperature` = '$tem',`humidity` = '$hum' where `roomID` = '$roomID' limit 1");
						if($ms and $rs){
							$msg ="roomID ".$roomID." current temperture ".$tem."\n"."roomID ".$roomID." current humifity ".$hum."\n";
							echo $msg;
						}else{
							$msg =date("Y-m-d H:i:s",time())." : signal ".$buf." is lost\n";
							echo $msg;
						}
					}
				}
				break;
			
			case 'RFI'://读卡信息  假设读卡信号 RFI14523650# 表示读到RFID卡14523650
				$rfid = substr($buf,3,8);
				$sql = "select * from `rfid` where id = '$rfid'";
				$ms =mysql_query($sql);
				if(is_array($ms)){
					$sql1 = "update `rfid` set `status` = 0 where id ='$rfid'";
					if($mx=mysql_query($sql1)){
						$msg ="RFID ".$rfid." is activating\n";
						echo $msg;
					}else{
						$msg =date("Y-m-d H:i:s",time())." : signal ".$buf." is lost\n";
						echo $msg;
					}
				}else{
					$sql2 = "insert into `rfid` value('$rfid','','0')";
					if($my=mysql_query($sql2)){
						$msg ="RFID ".$rfid." is activating\n";
						echo $msg;
					}else{
						$msg =date("Y-m-d H:i:s",time())." : signal ".$buf." is lost\n";
						echo $msg;
					}
				}
				
				break;
			default :
				$msg =date("Y-m-d H:i:s",time())." : signal ".$buf." is lost\n";
				echo $msg;
				break;
		}
	
	
		//更新护士节点的状态
	 	$nurse = $mysql->select('servant');
		while($nurse=$mysql->fetch_assoc()){
			if( ($now = time()) - $nurse['updatetime'] > 60){
				$rs = @mysql_query("UPDATE `servant` SET `status` = 0 ,`updatetime` ={$now}  WHERE `serverID` = {$nurse['serverID']} LIMIT 1");
				if($rs){
					//正常运营时此处去掉注释
					//$msg =$now.":nurse ".$nurse['servantID']." offline\n";
					//echo $msg;
				}else{
					$msg =date("Y-m-d H:i:s",time())." : signal ".$buf." is lost123\n";
					echo $msg;
				}
			}
		}
     
		//更新病人节点的状态
	 	$gravida = $mysql->select('gravida');
		while($gravida=$mysql->fetch_assoc()){
			if( ($now = time()) - $gravida['updatetime'] > 60){
				$rs = @mysql_query("UPDATE `gravida` SET `status` = 0 ,`updatetime` ={$now}  WHERE `roomID` ={$gravida['roomID']} LIMIT 1 ");
				if($rs){
					//正常运营时此处去掉注释
					//$msg =$now.":gravida ".$gravida['homeID']." offline\n";
					//echo $msg;
				}else{
					$msg =date("Y-m-d H:i:s",time())." : signal ".$buf." is lost\n";
					echo $msg;
				}
			}
		}

    //usleep( 1000 );
}
?>