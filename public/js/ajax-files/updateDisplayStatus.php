<?php
include '../common.php';
$status = $_POST['status'];
$pd_id = $_POST['pd_id'];
$sql = 'update product set pd_display_status = "'.$status.'" where pd_id = "'.$pd_id.'"';
mysql_query($sql);
?>