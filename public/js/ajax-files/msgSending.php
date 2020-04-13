<?php
include "../common.php";

$msg_to_id = $_POST['msg_to_id'];


$msg_subject = $_POST['msg_subject'];
$msg_body = $_POST['msg_body'];


/*if($msg_to_email == $_SESSION['uid'])
{
	echo '0';
}
else
{*/
	$sql_chk = 'select * from user where u_id in('.$msg_to_id.') and u_id != "'.$_SESSION["uid"].'" and u_status = "1"';
	$res_chk = mysql_query($sql_chk);
	

	if($msg_to_id == '')
	{
		echo '1';
	}
/*	else if($msg_to_email == $_SESSION['eml'])
	{
		echo '5';
	}
	else if(!mysql_num_rows($res_chk)>0)
	{
		echo '2';
	}*/
	else if($msg_subject == '')
	{
		echo '3';
	}
	else if($msg_body == '')
	{
		echo '4';
	}
	else
	{
		while($row_chk = mysql_fetch_object($res_chk))
		{
			$sql="insert into message
				set	
					msg_from_id ='".$_SESSION['uid']."',
					msg_to_id ='".$row_chk->u_id."',
					msg_subject ='".$msg_subject."',
					msg_body ='".$msg_body."',
					msg_date = now(),
					msg_time = now()";
			
			mysql_query($sql);
			
			$msg_id=mysql_insert_id();
			
			$sql_tf="select * from temp_attach_file where taf_u_id='".$_SESSION['uid']."'";
			$res_tf=mysql_query($sql_tf);
			while($row_tf=mysql_fetch_object($res_tf))
			{
				$sql_mf="insert into message_attachment_file
					set
						maf_msg_id='".$msg_id."',
						maf_fileName='".$row_tf->taf_file."'";
				
				if(mysql_query($sql_mf))
                        {
                            $sql_del="delete from temp_attach_file where taf_id='".$row_tf->taf_id."'";
                            mysql_query($sql_del);
                        }
			}
                  
		}
	}
/*  }   */
?>