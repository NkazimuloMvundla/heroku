<?php
ob_start();
session_start();
include "../common.php";

$ph_id=$_POST['id'];
$uid=$_SESSION['uid'];


$sql_ph="select * from photo where ph_id='".$ph_id."'";
$res_ph=mysql_query($sql_ph);
$row_ph=mysql_fetch_object($res_ph);
		
		
$sql="insert into product_temp_image
	set
		pti_uid='".$uid."',
		pti_image='".$row_ph->ph_fileName."',
		pti_updated_date=now()";
		
mysql_query($sql);

?>