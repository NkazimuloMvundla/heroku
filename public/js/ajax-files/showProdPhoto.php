<?php
ob_start();
session_start();
include "../common.php";

$pd_id=$_GET['id'];

$sqlImg="select * from product where pd_id='".$pd_id."'";
$resImg=mysql_query($sqlImg);
$rowImg=mysql_fetch_object($resImg);
				
$pathB="upload/product_image/250x250/".$rowImg->pd_photo;

echo $pathB;
?>