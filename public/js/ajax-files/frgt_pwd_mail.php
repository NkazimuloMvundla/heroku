<?php
include '../common.php';
/* Code by David McKeown - craftedbydavid.com */
/* Editable entries are bellow */

function cleanupentries($entry) {
	$entry = trim($entry);
	$entry = stripslashes($entry);
	$entry = htmlspecialchars($entry);

	return $entry;
}


/*Be careful when editing below this line */

$f_email = cleanupentries($_POST["email"]);
/*$from_ip = $_SERVER['REMOTE_ADDR'];
$from_browser = $_SERVER['HTTP_USER_AGENT'];*/

$newpwd = rand();
$send_to = $f_email;
$f_message = $lang[507].$newpwd;
$send_subject = "";


$sq = $pdo->prepare("select * from admin_user where status = ? ");
$sq->bindValue(1, 1 ,PDO::PARAM_INT);
$sq->execute();
$rowemail = $sq->fetch(PDO::FETCH_OBJ);
//var_dump($rowemail);


$message = $lang[508] . date('m-d-Y') . 
"\n\n".$lang[527].$rowemail->email .
"\n\n".$lang[528]."\n" . $f_message .
"\n ".$lang[509]."\n";

$send_subject .= $lang[510];

$headers = "From: " .$rowemail->email. "\r\n" .
    "Reply-To: " . $rowemail->email . "\r\n" ;




$sqlImg = $pdo->prepare("UPDATE user set u_password  = ?   WHERE  u_email = ? ");
$sqlImg->bindValue(1, password_hash($newpwd, PASSWORD_DEFAULT) , PDO::PARAM_STR) ;
$sqlImg->bindValue(2, $f_email , PDO::PARAM_INT) ;
$sqlImg->execute();


if($sqlImg->execute()){
mail($send_to, $send_subject, $message, $headers);
echo "true";
	
}

?>	