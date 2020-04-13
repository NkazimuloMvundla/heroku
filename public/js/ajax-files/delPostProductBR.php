<?php
include '../common.php';
$br_id = $_POST['br_id'];
mysql_query('update buy_request set br_status = "0" where br_id = "'.$br_id.'"');
?>