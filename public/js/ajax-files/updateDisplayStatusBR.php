<?php
include '../common.php';
$status = $_POST['status'];
$br_id = $_POST['br_id'];
$sql = 'update buy_request set br_display_status = "'.$status.'" where br_id = "'.$br_id.'"';
mysql_query($sql);
?>