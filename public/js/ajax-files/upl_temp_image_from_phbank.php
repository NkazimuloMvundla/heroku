<?php
ob_start();
session_start();
include "../common.php";

$ph_id=$_POST['id'];
$uid=$_SESSION['uid'];

$sql_ph="select * from photo where ph_id='".$ph_id."'";
$res_ph=mysql_query($sql_ph);
$row_ph=mysql_fetch_object($res_ph);

$sourcePath ="../upload/product_image/140x139/".$row_ph->ph_fileName;
$targetFolder = "../message_attachment/".$row_ph->ph_fileName;


if (copy($sourcePath, $targetFolder)) {
    $sql="insert into temp_attach_file
		set				
			taf_u_id ='".$uid."',
			taf_file ='".$row_ph->ph_fileName."'";
	
mysql_query($sql) or die(mysql_error());
}

?>