<?php
ob_start();
session_start();
include "../common.php";

$id=$_GET['id'];

$sqlImg="select * from product_temp_image where pti_uid='".$id."' order by pti_id desc limit 1";
$resImg=mysql_query($sqlImg);

$path="";

if(mysql_num_rows($resImg)>0)
{
	$rowImg=mysql_fetch_object($resImg);
				
	$path="upload/product_image/250x250/".$rowImg->pti_image;
}
else
{
	$path="images/bg_no_image.gif";
}

echo $path;
?>