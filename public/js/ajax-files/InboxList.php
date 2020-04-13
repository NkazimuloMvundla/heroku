<?php 
include '../common.php'; 

if($_POST['page'])
{
$page = $_POST['page'];
$cur_page = $page;
$page -= 1;
$per_page = 10; // Per page records
$previous_btn = true;
$next_btn = true;
//$first_btn = false;
//$last_btn = false;
$start = $page * $per_page;
	
$query_pag_data = "select * from message where msg_to_id='".$_SESSION['uid']."' and msg_to_id != msg_from_id and msg_to_status='0' order by msg_id desc LIMIT $start, $per_page";
$result_pag_data = mysql_query($query_pag_data) or die('MySql Error' . mysql_error());

/* -----Total count--- */
$query_pag_num = "SELECT count(*) AS count from message where msg_to_id='".$_SESSION['uid']."' and msg_to_id != msg_from_id and msg_to_status='0'"; // Total records

$result_pag_num = mysql_query($query_pag_num);
$row = mysql_fetch_array($result_pag_num);
$count = $row['count'];
$no_of_paginations = ceil($count / $per_page);

/* ---------------Calculating the starting and endign values for the loop----------------------------------- */
if ($cur_page >= 7) {
    $start_loop = $cur_page - 3;
    if ($no_of_paginations > $cur_page + 3)
        $end_loop = $cur_page + 3;
    else if ($cur_page <= $no_of_paginations && $cur_page > $no_of_paginations - 6) {
        $start_loop = $no_of_paginations - 6;
        $end_loop = $no_of_paginations;
    } else {
        $end_loop = $no_of_paginations;
    }
} else {
    $start_loop = 1;
    if ($no_of_paginations > 7)
        $end_loop = 7;
    else
        $end_loop = $no_of_paginations;
}


?>
    
	
    <div class="allin-toolbar util-clearfix" id="inboxTopBar">
    	<div node="66" class="option-list list"><a href='javascript:deleteInbox();' title="<?php echo $lang[169]; ?>" store="4" data-id="delete" node="69" class="allin-toolbar-btn"><span node="74" class="allin-icon icon-t-del"></span><span class="allin-text"><?php echo $lang[169]; ?></span></a></div>

	</div>
    <form name="m_inbox" id="m_inbox" method='post'>
    <div id="inboxGrid">
    <div id="grid-inboxGrid" class="allin-grid ">
    
    
    <!--INBOX list-->
    <table id="grid-header-inboxGrid" class="allin-grid-header ">
    <thead>
    <tr>
    <th class="c-check table-option-list">
    <a iscontextmenu="true" href="javascript:void(0);" class="j-filter">
    <input class="select-all" name="check_all" value="yes" id="check_all" type="checkbox" onClick="return checkedAll_inbox();"><span class="icon icon-t-drop"> </span></a></th>
    <th class="c-marking"></th>
    <th class="c-addresser j-detail"><span class="allin-grid-text"><?php echo $lang[511]; ?></span>
    <!--<span title="Sort by Sender" data-order-by="senderDisplayName" class="allin-icon icon-sort-list icon-sort-normal"></span>-->
    </th>
    <th class="c-contact j-detail"></th>
    <th class="c-subject j-detail no-border-right"><?php echo $lang[124]; ?></th><th class="c-task"></th>
    <th class="c-attachment j-detail"><span class="allin-icon icon-attachment"> </span></th>
    <th class="c-date j-detail"><span class="allin-grid-text"><?php echo $lang[512]; ?></span><!--<span title="Sort by Date" data-order-by="gmtCreate" class="allin-icon icon-sort-list icon-sort-reverse"></span>--></th>
    <th class="c-country j-detail"><!--<span title="Sort by Country/Region" data-order-by="senderCountry" class="allin-icon icon-sort-list icon-sort-normal"></span>--></th><th class="c-user-type j-detail"></th>
    </tr>
    </thead>
    </table>
   
   <!---Inbox Message--->
  
   
    <div id="grid-body-inboxGrid" class="allin-grid-body allin-grid-content ">
    <?php 
	if(mysql_num_rows($result_pag_data)>0){ 

	while ($row_inbox = mysql_fetch_object($result_pag_data))
	{ ?>
    <div <?php if($row_inbox->msg_read != '1'){ ?> style='background-color: #53B0FD' <?php } ?>>
    <table id="grid-row-74" class="allin-grid-row focus">
    <tbody>
    <tr>
    	<td class="c-check table-option-list">
        <a href="javascript:void(0);">
        <input data-msgid="739381176"  id="cbI" name="cbI" type="checkbox" value="<?php echo $row_inbox->msg_id; ?>" >
        </a>
        </td>
        <td class="c-toggle"> </td>
        <td class="c-addresser j-detail">
        <a data-online="0" title="Please Leave a Message" rel="nofollow" class="icon-grey icon-PngGrey" href="" id="talkId-75">
        </a>
        <?php  $sql_sndr = 'select * from user where u_id = "'.$row_inbox->msg_from_id.'"';
			   $res_sndr = mysql_query($sql_sndr);
			   $row_sndr = mysql_fetch_object($res_sndr);
		?>        <a title="<?php echo ucfirst($row_sndr->u_firstName).' '.ucfirst($row_sndr->u_lastName); ?>" href='javascript:showMsgDetailsInbox();showMsg(<?php echo $row_inbox->msg_id; ?>,<?php echo $cur_page; ?>);'><?php echo ucfirst($row_sndr->u_firstName).' '.ucfirst($row_sndr->u_lastName); ?></a>
    	</td>
		<td class="c-contact j-detail"><span class="icon icon-null j-contact" title=""> </span></td>
        <td class="c-subject j-detail no-border-right">
        <a title="<?php echo $row_inbox->msg_subject; ?>" href="javascript:showMsgDetailsInbox();showMsg(<?php echo $row_inbox->msg_id; ?>,<?php echo $cur_page; ?>);"><?php echo $row_inbox->msg_subject; ?></a></td>
        <td class="c-task">
        <span class="icon icon-no-task j-follow" title="Flag this message as incomplete"> </span></td>
        <td class="c-attachment j-detail">
        <?php
			$sql_attach="select count(*) as cnt from message_attachment_file where maf_msg_id='".$row_inbox->msg_id."'";
			$res_attach=mysql_query($sql_attach);
			$row_attach=mysql_fetch_object($res_attach);
			
			if($row_attach->cnt > 0){
		?>
        	<span class="allin-icon icon-attachment"> </span>
        <?php	}	?>
        </td>
        <td class="c-date j-detail"><a title="<?php echo $row_inbox->msg_time; ?>" onClick="return false;"><?php echo $row_inbox->msg_time; ?></a>
        </td>
        <td class="c-country j-detail">
        <!--<span title="China (Mainland)" onMouseOver="this.title=feedback.countryClockMgr.getNowTime('CN','China (Mainland)')" class="country-flag css_cn"></span>-->
        <?php $sql_cn = "SELECT * FROM country join city WHERE cn_id=ct_cn_id and ct_id = '".$row_sndr->u_ct_id."'";
			  $row_cn =  mysql_fetch_object(mysql_query($sql_cn));
		?>
			  <img src="upload/flags/<?php echo $row_cn->cn_flag; ?>" />
		
        </td>
        <td class="c-user-type j-detail"><!--<span class="icon icon-cgs" title="Gold Suplier"> </span>--></td>
	</tr>
    </tbody>
    </table>
    </div>
<?php
	} 
	}else{
?>    
    
<!---end  Inbox Message--->
   <div> 
    <table class="allin-grid-row table-no-result">
    <tbody>
    <tr>
    <td><div class="allin-grid-empty"><?php echo $lang[513]; ?></div></td>
    </tr>
    </tbody>
    </table>
    </div>
  <?php } ?>
    </div>
    </form>
    
    </div>
    </div>
    <div class="allin-toolbar util-clearfix" id="inboxBtmBar"><div node="79" class="option-list list">
    	<a href='javascript:deleteInbox();' title="<?php echo $lang[169]; ?>" store="4" data-id="delete" node="82" class="allin-toolbar-btn">
        	<span node="87" class="allin-icon icon-t-del"></span><span class="allin-text"><?php echo $lang[169]; ?></span>
		</a>
        <!--<a title="Report Spam" store="5" data-id="spam" node="83" class="allin-toolbar-btn"><span node="88" class="allin-icon icon-t-spam"></span><span class="allin-text">Report Spam</span></a><a title="Add Contacts" store="6" data-id="addContact" node="84" class="allin-toolbar-btn"><span node="89" class="allin-icon icon-client-a"></span><span class="allin-text">Add Contacts</span></a>-->
	</div>
    <div class="allin-pager-bar" id="inboxPager">
    <?php
	// FOR ENABLING THE PREVIOUS BUTTON
	if ($previous_btn && $cur_page > 1){
		$pre = $cur_page - 1;
		?>
        <a style="" href="javascript:showInboxList('<?php echo $pre; ?>')" title="<?php echo $lang[517]; ?>" class="prev"><?php echo $lang[517]; ?></a>
	<?php	}else if($previous_btn){	?>
        <a style="opacity:0.2;text-decoration:none;" title="<?php echo $lang[517]; ?>" class="prev"><?php echo $lang[517]; ?></a>
	<?php	}	
	
	// TO ENABLE THE NEXT BUTTON	
	if ($next_btn && $cur_page < $no_of_paginations)
	{
    	$nex = $cur_page + 1;
		?>
        <a href="javascript:showInboxList('<?php echo $nex; ?>')" title="<?php echo $lang[249]; ?>" class="next"><?php echo $lang[249]; ?></a>
        <?php
	}
	else if ($next_btn)
	{
		?>
		<a title="<?php echo $lang[249]; ?>" style="opacity:0.2;text-decoration:none;" class="next"><?php echo $lang[249]; ?></a>
        <?php
	}
	?>

        <select id="inboxPager-pageNumber" onchange="javascript:showInboxList(this.value)">
        <?php	for ($i = $start_loop; $i <= $end_loop; $i++){	?>
			<option value="<?php echo $i; ?>" <?php if($cur_page == $i){ ?> selected="selected" <?php } ?>><?php echo $i; ?></option>
        <?php	}	?>
        </select>
	</div>
</div>

<?php	}	?>