<?php
include "../common.php";
$email = $_POST['oldemail'];
$sql = 'select * from user where u_email = "'.$email.'" and u_id="'.$_SESSION['uid'].'" and u_status = "1"';
$res = mysql_query($sql);
if(mysql_num_rows($res)>0)
{
	echo '0';
}
else
{
	echo '1';
}
?>