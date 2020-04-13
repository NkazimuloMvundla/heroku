<?php
include "../common.php";
	$q=$_GET['q'];
	$my_data=mysql_real_escape_string($q);
	$sql="SELECT * FROM product WHERE pd_status='1' and pd_name LIKE '$my_data%' ORDER BY pd_name";

	$result = mysql_query($sql);
	
	if($result)
	{
		while($row=mysql_fetch_object($result))
		{
			echo ucfirst(stripslashes($row->pd_name))."|".$row->pd_id."\n";
		}
	}
?>