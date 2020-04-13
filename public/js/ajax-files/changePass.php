<?php
include '../common.php';
$oldPwd = $_POST['oldPwd'];
$newPwd = $_POST['newPwd'];
$rptPwd = $_POST['rptPwd'];

$res_chk = mysql_query("select * from user where u_email = '".$_SESSION['eml']."' and u_password = '".md5($oldPwd)."'");
if(mysql_num_rows($res_chk)==0)
{
	echo '1';
}
else
{
	if(strlen($newPwd)<6 || strlen($newPwd)>20 )
		{
			echo '2';
		}
		elseif(!validate::is_password($newPwd))
		{
			echo '3';
		}	
		elseif($newPwd != $rptPwd)
		{
			echo '4';
		}
		else
		{ 
			$pass = md5($newPwd);
			$sql = 'update user set u_password = "'.$pass.'" where u_id = "'.$_SESSION['uid'].'"';
			if(mysql_query($sql))
			{
				echo '0';
			}
		}
}


?>