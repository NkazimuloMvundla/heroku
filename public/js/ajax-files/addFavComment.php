<?php
include '../common.php';

$uid = $_POST['uid'];
$pid = $_POST['pid'];
$comment = $_POST['favComment'];

mysql_query('insert into my_fav_comment set mfc_u_id = "'.$uid.'",mfc_pd_id = "'.$pid.'",mfc_comment = "'.$comment.'"');
?>