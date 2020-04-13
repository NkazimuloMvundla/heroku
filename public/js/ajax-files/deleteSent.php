<?php
include '../common.php';

$msg = $_POST['msg'];
$msg_id = explode(',',$msg);

foreach($msg_id as $mid)
{
	 	mysql_query("update message set msg_from_status = '1' where msg_id = '".$mid."'");	
}
?>