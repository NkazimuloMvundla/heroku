<?php 
include "../common.php";
$uid=$_POST['id'];
//if(!isset($_SESSION['uid'])){ $uid=$_POST['uid']; }
$targetFolder = '../message_attachment'; // Relative to the root

if (!empty($_FILES)) {
	$tempFile   = $_FILES['Filedata']['tmp_name'];
	//$uploadDir  = $_SERVER['DOCUMENT_ROOT'] . $uploadDir;
	//$targetFile = $uploadDir . $_FILES['Filedata']['name'];
	$targetPath = $targetFolder;
	// Set the allowed file extensions
	$fileTypes = array('jpg', 'jpeg', 'gif', 'png', 'doc', 'pdf', 'txt', 'docx', 'xls'); // Allowed file extensions

	// Validate the filetype
	$fileParts = pathinfo($_FILES['Filedata']['name']);

	if(in_array(strtolower($fileParts['extension']), $fileTypes))
	{
        $vid=$uid.''.date("YmdHis");
        $filename=''.$vid.'.'.$fileParts['extension'].'';
	    $targetFile = rtrim($targetPath,'/') . '/' . $vid.'.'.$fileParts['extension'];
		move_uploaded_file($tempFile,$targetFile);
	
		$sql="insert into temp_attach_file
			set				
				taf_u_id ='".$uid."',
				taf_file ='".$filename."'";
		
		
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