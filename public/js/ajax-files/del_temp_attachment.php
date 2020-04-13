<?php
include "../common.php";

$id=$_GET['id'];

$sql="select * from temp_attach_file where taf_id='".$id."'";
$res=mysql_query($sql);
$row=mysql_fetch_object($res);

$path="../message_attachment/".$row->taf_file;

if(is_file($path)){	unlink($path);	}


$sql_del="delete from temp_attach_file where taf_id='".$id."'";
mysql_query($sql_del);
?>