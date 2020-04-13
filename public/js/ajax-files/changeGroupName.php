<?php
ob_start();
session_start();
include "../common.php";

$pg_id=$_POST['id'];
$pg_name=$_POST['pg_name'];

$sql="update photo_group
	set
		pg_name='".$pg_name."'
	where
		pg_id='".$pg_id."'";

mysql_query($sql);


?>