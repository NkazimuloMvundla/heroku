<?php
include '../common.php';

$msg = $_POST['msg'];
$msg_id = explode(',',$msg);

foreach($msg_id as $mid)
{
	 		$get_sql=mysql_query("select * from message where msg_id = '".$mid."'");
			$get_id=mysql_fetch_array($get_sql);
			
			if($_SESSION['uid']==$get_id['msg_to_id'])
			{
		    		if(mysql_query("update message set msg_to_status = '2' where msg_id = '".$mid."'"))
					{  echo '1'; }
			}
			if($_SESSION['uid']==$get_id['msg_from_id'])
			{
		    		if(mysql_query("update message set msg_from_status = '2' where msg_id = '".$mid."'"))
					{  echo '1'; }
			}
}
?>