<?php
ob_start();
session_start();
include "../common.php";

$uid=$_POST['id'];

$targetFolder = '../upload/products_image/'; // Relative to the root

if(!empty($_FILES))
{
	
	$temp_image='img'.date("YmdHis").rand(10,99).trim(addslashes($_FILES['Filedata']['name']));	
	
	$fileTypes = array('jpg','jpeg','gif','png'); // File extensions
	$fileParts = pathinfo($_FILES['Filedata']['name']);
	
	if (in_array(strtolower($fileParts['extension']),$fileTypes))
	{
		$imgSImage = new SimpleImage();			
		$imgSImage->load($_FILES['Filedata']['tmp_name']);
				
		$imgSImage->resize(800,799);
		$imgSImage->save("../upload/product_image/800x799/".$temp_image);
				
		$imgSImage->resize(250,250);
		$imgSImage->save("../upload/product_image/250x250/".$temp_image);
				
		$imgSImage->resize(140,139);
		$imgSImage->save("../upload/product_image/140x139/".$temp_image);	

		$imgSImage->resize(95,100);
		$imgSImage->save("../upload/product_image/95x100/".$temp_image);	

		/*move_uploaded_file($_FILES["Filedata"]["tmp_name"], "../upload/product_image/800x799/".$temp_image) or die('error');
		move_uploaded_file($_FILES["Filedata"]["tmp_name"], "../upload/product_image/250x250/".$temp_image) or die('error');
		move_uploaded_file($_FILES["Filedata"]["tmp_name"], "../upload/product_image/140x139/".$temp_image) or die('error');
		move_uploaded_file($_FILES["Filedata"]["tmp_name"], "../upload/product_image/95x100/".$temp_image) or die('error');
		move_uploaded_file($tempFile,$targetFile);*/
		
		
		
		
		$sql="insert into product_temp_image
			set
				pti_uid='".$uid."',
				pti_image='".$temp_image."',
				pti_updated_date=now()";
		
		echo $sql;
		mysql_query($sql);
		
		//echo $sql;
	} else {
		echo $lang[479];
	}
}

?>