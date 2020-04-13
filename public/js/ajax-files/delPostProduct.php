<?php
include '../common.php';
$pd_id = $_POST['pd_id'];
mysql_query('update product set pd_status = "0" where pd_id = "'.$pd_id.'"');
?>