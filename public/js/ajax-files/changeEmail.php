<?php
include "../common.php";
$email = trim($_POST['newemail']);
$hideEmail = trim($_POST['hideEmail']);
$sql = 'update user set u_email = "'.$email.'" where u_email = "'.$hideEmail.'"';
if(mysql_query($sql))
{	
	$_SESSION['eml'] = $email;
}/**/
?>