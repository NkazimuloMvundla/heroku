<?php
include "../common.php";

if($_POST['u']=='')
{
	$str=0;
}
else
{
	$str=$_POST['u'];
}

$sql="select * from user where u_id in(".$str.")";

$res=mysql_query($sql);
$count=mysql_num_rows($res);
$nm="";
if($count>0)
{
	while($row=mysql_fetch_object($res))
	{
		$nm.=$row->u_firstName." ".$row->u_lastName.";";
	}
}
echo $count."|".$nm;
?>