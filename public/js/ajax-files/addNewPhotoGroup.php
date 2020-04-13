<?php
ob_start();
session_start();
include "../common.php";

$pg_name=$_POST['pg_name'];
$pg_u_id=$_SESSION['uid'];

$sql="insert into photo_group
	set
		pg_u_id='".$pg_u_id."',
		pg_name='".$pg_name."',
		pg_updated_date=now()";

mysql_query($sql);

echo mysql_insert_id();

?>