<?php
include '../common.php';
$status = $_POST['status'];
$br_id = $_POST['br_id'];
$pid = explode(',',$br_id);
//print_r($pid);
foreach($pid as $val){
$sql = 'update buy_request set br_display_status = "'.$status.'" where br_id = "'.$val.'"';
mysql_query($sql);
}
?>