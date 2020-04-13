<?php
ob_start();
session_start();
include "../common.php";

$pg_id=$_POST['id'];

$sql="update photo
	set
		ph_pg_id='0'
	where
		ph_pg_id='".$pg_id."'";

mysql_query($sql);

$sql_del="delete from photo_group where pg_id='".$pg_id."'";
mysql_query($sql_del);

?>