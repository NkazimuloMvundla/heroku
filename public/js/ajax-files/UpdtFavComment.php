<?php
include '../common.php';

$cid = $_POST['cid'];
$comment = $_POST['favCommentUpdt'];

mysql_query('update my_fav_comment set mfc_comment = "'.$comment.'" where mfc_id = "'.$cid.'"');
?>