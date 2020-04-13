<?php
include '../common.php';
date_default_timezone_set('UTC');
$mid = $_POST['mid'];
$page = $_POST['page'];
mysql_query('update message set msg_read = "1" where (msg_id = "'.$mid.'" and msg_to_id = "'.$_SESSION['uid'].'")');
$sql = 'select * from message where msg_id = "'.$mid.'"';
$res = mysql_query($sql);
$row = mysql_fetch_object($res);
?>

  <div class="detail-header" id="sendDetailHeader">
  <div class="clear">
  <div class="allin-toolbar util-clearfix" id="sendDetailBtmBar">
  <div node="105" class="option-list list">
  <a title="<?php echo $lang[519]; ?>" store="23" data-id="goback" node="106" class="allin-toolbar-btn" <?php if(($row->msg_to_status=='1' && $row->msg_to_id==$_SESSION['uid']) || ($row->msg_from_status=='1' && $row->msg_from_id==$_SESSION['uid'])){ ?> href="javascript:showTrashMail(<?php echo $page; ?>);" <?php } else if($row->msg_to_id==$_SESSION['uid']){ ?> href="javascript:showInbox(<?php echo $page; ?>);" <?php } else if($row->msg_from_id==$_SESSION['uid']){ ?> href="javascript:showSendMail(<?php echo $page; ?>);" <?php } ?> >
  <span node="109" class="allin-icon icon-back"></span><span class="allin-text"><?php echo $lang[519]; ?></span>
  </a>
  
  <a title="<?php echo $lang[169]; ?>" store="24" data-id="delete" node="107" class="allin-toolbar-btn" <?php if($row->msg_to_id==$_SESSION['uid']){ ?> onclick="javascript:deleteInboxDetail(<?php echo $row->msg_id; ?>,<?php echo $page; ?>);" <?php } if($row->msg_from_id==$_SESSION['uid']){ ?> onclick="javascript:deleteSentDetail(<?php echo $row->msg_id; ?>,<?php echo $page; ?>);" <?php  }  if(($row->msg_to_status=='1' && $row->msg_to_id==$_SESSION['uid']) || ($row->msg_from_status=='1' && $row->msg_from_id==$_SESSION['uid'])){ ?> onclick="javascript:deleteTrashDetail(<?php echo $row->msg_id; ?>,<?php echo $page; ?>);" <?php }?> ><span node="110" class="allin-icon icon-t-del"></span><span class="allin-text"><?php echo $lang[169]; ?></span></a>
  <?php if($_SESSION['uid'] != $row->msg_from_id){ ?>
  <a title="Resend" store="25" data-id="reply" node="108" class="allin-toolbar-btn"
  href="javascript:composeReplyMail();replyMail(<?php echo $row->msg_id; ?>);"
  ><span node="111" class="allin-icon icon-t-reply"></span>
  <span class="allin-text"><?php echo $lang[520]; ?></span></a><?php } ?>
  </div></div></div>
  <div class="detail-title">
  <span class="text detail-subject"><?php echo $row->msg_subject; ?></span>
  <span class="allin-icon icon-no-task j-follow" title="Flag this message as incomplete"></span>
  </div>
  <ul class="detail-info">
  <li><label class="detail-info-label">Date:</label> <?php echo date("d-M-Y",strtotime($row->msg_date)).' '.strftime("%I:%M %p",strtotime($row->msg_time));  ?> </li>
  <li><label class="detail-info-label">
  From:
  
  </label>
<?php 

			   $sql_from = 'select * from user where u_id = "'.$row->msg_from_id.'"';
			   $res_from = mysql_query($sql_from);
			   $row_from = mysql_fetch_object($res_from);
			   
			   echo ucfirst($row_from->u_firstName).' '.ucfirst($row_from->u_lastName);
?>
 </li>
 
  <li><label class="detail-info-label">
 
  <?php echo $lang[497]; ?>
  
  </label>
<?php 

			   $sql_to = 'select * from user where u_id = "'.$row->msg_to_id.'"';
			   $res_to = mysql_query($sql_to);
			   $row_to = mysql_fetch_object($res_to);
			   
			   echo ucfirst($row_to->u_firstName).' '.ucfirst($row_to->u_lastName);
?>
  </li>
  </ul>
    </div>
  <div class="clear">&nbsp;</div>
  <div>
  <div style="float:left;width:50px;height:400px">&nbsp;</div>
  
  <div style="float:left;width:700px;height:400px">
  <div id="content" class="content" data-show-filter="false">
  <?php echo $row->msg_body; ?>
  </div>
  <div class="clear">&nbsp;</div>
  <div class="clear">&nbsp;</div>
	<?php
		$sql_attach="select * from message_attachment_file where maf_msg_id='".$row->msg_id."'";
		$res_attach=mysql_query($sql_attach);
		while($row_attach=mysql_fetch_object($res_attach)){
		?>
        
          <div class="clear">&nbsp;</div>
       	<span class="allin-icon icon-attachment"></span>&nbsp;<?php	echo $row_attach->maf_fileName;	?>&nbsp;&nbsp;<a href="download.php?m=<?php echo $row_attach->maf_id; ?>">Download</a>
             
	<?php	}	?>
    <div class="disclaimer">
    <?php echo $lang[521]; ?>
    </div>

  </div> 
  
 
 </div> 
 
  <div class="clear"><div class="allin-toolbar util-clearfix" id="sendDetailBtmBar"><div node="105" class="option-list list">
  
  <a title="<?php echo $lang[519]; ?>" store="23" data-id="goback" node="106" class="allin-toolbar-btn" <?php if(($row->msg_to_status=='1' && $row->msg_to_id==$_SESSION['uid']) || ($row->msg_from_status=='1' && $row->msg_from_id==$_SESSION['uid'])){ ?> href="javascript:showTrashMail(<?php echo $page; ?>);" <?php } else if($row->msg_to_id==$_SESSION['uid']){ ?> href="javascript:showInbox(<?php echo $page; ?>);" <?php } else if($row->msg_from_id==$_SESSION['uid']){ ?> href="javascript:showSendMail(<?php echo $page; ?>);" <?php } ?> >
  <span node="109" class="allin-icon icon-back"></span><span class="allin-text"><?php echo $lang[519]; ?></span>
  </a>
  
  
  <a title="<?php echo $lang[169]; ?>" store="24" data-id="delete" node="107" class="allin-toolbar-btn" <?php if($row->msg_to_id==$_SESSION['uid']){ ?> onclick="javascript:deleteInboxDetail(<?php echo $row->msg_id; ?>,<?php echo $page; ?>);" <?php } if($row->msg_from_id==$_SESSION['uid']){ ?> onclick="javascript:deleteSentDetail(<?php echo $row->msg_id; ?>,<?php echo $page; ?>);" <?php  }  if(($row->msg_to_status=='1' && $row->msg_to_id==$_SESSION['uid']) || ($row->msg_from_status=='1' && $row->msg_from_id==$_SESSION['uid'])){ ?> onclick="javascript:deleteTrashDetail(<?php echo $row->msg_id; ?>,<?php echo $page; ?>);" <?php }?> ><span node="110" class="allin-icon icon-t-del"></span><span class="allin-text"><?php echo $lang[169]; ?></span></a>
  
  <?php if($_SESSION['uid'] != $row->msg_from_id){ ?>
  <a title="Resend" store="25" data-id="reply" node="108" class="allin-toolbar-btn"
  href="javascript:composeReplyMail();replyMail(<?php echo $row->msg_id; ?>);"
  ><span node="111" class="allin-icon icon-t-reply"></span>
  <span class="allin-text"><?php echo $lang[520]; ?></span></a><?php } ?>
  
          </div><div class="allin-pager-bar" id="sendDetailBtmPager"><a style="display: none;" title="<?php echo $lang[517]; ?>" href="javascript:;"><?php echo $lang[517]; ?></a><a style="display: none;" title="<?php echo $lang[249]; ?>" href="javascript:;"><?php echo $lang[249]; ?></a></div></div></div>