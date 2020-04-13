<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
include "../common.php";
//include '../lib/config.php';


$cn_id = filterInt($_POST['cn_id']);

$sql = "select * from city where ct_cn_id = ? and ct_status = ?";
$stmt= $pdo->prepare($sql);
$stmt->bindValue(1, $cn_id, PDO::PARAM_INT);
$stmt->bindValue(2, 1, PDO::PARAM_INT);
$stmt->execute();
if($stmt->rowCount()>0)
{
	echo "<option value=''>".filterString($lang[454])."</option>";
	while($row = $stmt->fetch())
	{		
		echo "<option value='".filterInt($row['ct_id'])."'>".filterString($row['ct_name'])."</option>";
		
	}
}
else
{
	echo "<option value=''>".filterString($lang[454])."</option>";
	
}

?>