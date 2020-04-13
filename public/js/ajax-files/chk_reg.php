<?php
include "../common.php";
//include '../lib/config.php';
include "../lib/language.php";


$flag = 0;
$err_msg = '';

$cn_id = filterInt($_POST['cn_id']);
$ct_id = filterInt($_POST['ct_id']);
$busns_role = filterString($_POST['busns_role']));
$firstName = filterString($_POST['firstName']));
$lastName = filterString($_POST['lastName']));
$comp_name = filterString($_POST['comp_name']));
$phoneNumber = filterString($_POST['phoneNumber']));
$email = filterEmail($_POST['email']));
$password = filterString($_POST['password']));
$hashedPassword = password_hash($password, PASSWORD_DEFAULT); 
$passwordConfirm = filterString($_POST['passwordConfirm']));
$passwordConfirmhashed = password_hash($passwordConfirm, PASSWORD_DEFAULT); 
$sql_email_chk = "select u_email from user where u_email = ? ";

$stmt= $pdo->prepare($sql_email_chk);
$stmt->bindValue(1,$email,PDO::PARAM_INT);
$stmt->execute();

if($cn_id == '')
{
	$flag = 1;
	$err_msg = $lang[269];
}
elseif($ct_id == '')
{
	$flag = 1;
	$err_msg = $lang[208];
}
elseif($busns_role == '')
{
	$flag = 1;
	$err_msg = $lang[448];
}
elseif($firstName == '')
{
    $flag = 1;
    $err_msg = $lang[305];
}
elseif(!validate::is_name($firstName))
{
    $flag = 1;
    $err_msg = $lang[306];
}
elseif($lastName == '')
{
    $flag = 1;
    $err_msg = $lang[307];
}
elseif(!validate::is_name($lastName))
{
    $flag = 1;
    $err_msg = $lang[308];
}
elseif($phoneNumber == '')
{
    $flag = 1;
    $err_msg = $lang[438];
}
elseif(!validate::is_phone($phoneNumber))
{
    $flag = 1;
    $err_msg = $lang[439];
}
elseif($email == '')
{
    $flag = 1;
    $err_msg = $lang[440];
}
elseif(!filter_var($email, FILTER_VALIDATE_EMAIL))
{
    $flag = 1;
    $err_msg = $lang[254];
}
elseif($stmt->rowCount() >0)
{
    $flag = 1;
    $err_msg = $lang[447];
}		
elseif($password == '')
{
    $flag = 1;
    $err_msg = $lang[493];
}
elseif(strlen($password)<6 || strlen($password)>20 )
{
    $flag = 1;
    $err_msg = $lang[444];
}
elseif(!validate::is_password($password))
{
    $flag = 1;
    $err_msg = $lang[443];
}
elseif($passwordConfirm == '')
{
    $flag = 1;
    $err_msg = $lang[445];
}		
elseif($password != $passwordConfirm)
{
    $flag = 1;
    $err_msg = $lang[446];
}
	
if($flag == 1)
{
    echo filterString($err_msg)."|0";
}
else		
{   
	$rpwd = $passwordConfirmhashed;
    $sql = "INSERT INTO user (u_ct_id, 	u_busnsRole, u_firstName,u_lastName,u_companyName, u_phoneNumber, 	u_email , 	u_password, u_reg_date   ) VALUES (?, ?,?,?,?,?,?,?,now())";
$st = $pdo->prepare($sql);
$st->bindValue(1, $ct_id,PDO::PARAM_INT);
$st->bindValue(2, $busns_role,PDO::PARAM_STR);
$st->bindValue(3, $firstName,PDO::PARAM_STR);
$st->bindValue(4, $lastName,PDO::PARAM_STR);
$st->bindValue(5, $comp_name,PDO::PARAM_STR);
$st->bindValue(6, $phoneNumber,PDO::PARAM_INT);
$st->bindValue(7, $email,PDO::PARAM_STR);
$st->bindValue(8, $rpwd,PDO::PARAM_STR);
$st->execute();
    echo filterString($lang[494]."|1");
    $_SESSION['msg']=filterString("<font color='#009900'>".$lang[495]."</font>");
}
?>