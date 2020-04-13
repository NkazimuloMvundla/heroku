<?php
include '../common.php';
$status = $_POST['status'];
$pd_id = $_POST['pd_id'];
$pid = explode(',',$pd_id);
//print_r($pid);
foreach($pid as $val){
$sql = 'update product set pd_display_status = "'.$status.'" where pd_id = "'.$val.'"';
mysql_query($sql);
}
?>