<?php 
include "../common.php";

$br_id=$_POST['id'];

$targetFolder = '../product_files'; // Relative to the root

if (!empty($_FILES)) {
	$tempFile   = $_FILES['Filedata']['tmp_name'];
	//$uploadDir  = $_SERVER['DOCUMENT_ROOT'] . $uploadDir;
	//$targetFile = $uploadDir . $_FILES['Filedata']['name'];
	$targetPath = $targetFolder;
	// Set the allowed file extensions
	$fileTypes = array('jpg', 'jpeg', 'gif', 'png', 'doc', 'pdf', 'txt'); // Allowed file extensions

	// Validate the filetype
	$fileParts = pathinfo($_FILES['Filedata']['name']);

	if(in_array(strtolower($fileParts['extension']), $fileTypes))
	{
        $vid=$uid.''.date("YmdHis");
        $imagename=''.$vid.'.'.$fileParts['extension'].'';
	    $targetFile = rtrim($targetPath,'/') . '/' . $vid.'.'.$fileParts['extension'];
		move_uploaded_file($tempFile,$targetFile);
	
		$sql="insert into buy_req_file
			set				
				brf_br_id ='".$br_id."',
				brf_fileName ='".$imagename."'";
	
		mysql_query($sql) or die(mysql_error());

	}
	else
	{
		// The file type wasn't allowed
		echo $lang[479];
	}

} else {

	echo $lang[526];

}
?>