<?php
include "../common.php";

$tf_id=$_GET['id'];

$sql="delete from temp_buy_req_file where tf_id='".$tf_id."'";
mysql_query($sql);
?>