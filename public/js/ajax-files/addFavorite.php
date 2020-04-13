<?php
include '../common.php';

$uid = $_POST['uid'];
$pid = $_POST['pid'];
$sql_chk = 'select * from my_favorite where mf_u_id = "'.$uid.'" and mf_pd_id = "'.$pid.'"';
$res_chk = mysql_query($sql_chk);
if(mysql_num_rows($res_chk)>0){
	echo '1';
}
else
{
mysql_query('insert into my_favorite set mf_u_id = "'.$uid.'",mf_pd_id = "'.$pid.'",mf_updated_date = now()');
echo '2';
}
?>