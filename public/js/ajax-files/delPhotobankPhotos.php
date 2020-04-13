<?php
include '../common.php';
$ph_id = $_POST['ph_id'];
$pid = explode(',',$ph_id);
//print_r($pid);
foreach($pid as $val){
$sql = 'update photo set ph_status = "0" where ph_id = "'.$val.'"';
mysql_query($sql);
}
$sql_ret="select distinct ph_pg_id from photo where ph_id in(".$ph_id.")";
$res_ret=mysql_query($sql_ret);
$row_ret=mysql_fetch_object($res_ret);
//echo $sql;
echo $row_ret->ph_pg_id;
?>