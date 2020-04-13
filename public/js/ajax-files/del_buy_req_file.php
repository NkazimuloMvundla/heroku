<?php
include "../common.php";

$brf_id=$_GET['id'];

$sql="delete from buy_req_file where brf_id='".$brf_id."'";
mysql_query($sql);
?>