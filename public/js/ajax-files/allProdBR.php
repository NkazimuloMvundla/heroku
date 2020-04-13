<?php
include '../common.php';
date_default_timezone_set('UTC');
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

$query_pag_data = "select * from buy_request where br_status = '1' and br_expired_time >='".date("Y-m-d")."' and br_u_id = '".$_SESSION['uid']."' order by br_id desc LIMIT $start, $per_page";
$result_pag_data = mysql_query($query_pag_data) or die('MySql Error' . mysql_error());

/* -----Total count--- */
$query_pag_num = "SELECT count(*) AS count from buy_request where br_status = '1' and br_expired_time >='".date("Y-m-d")."' and br_u_id = '".$_SESSION['uid']."'"; // Total records

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

/*****************************************************/
/*$sql = 'select * from buy_request where br_status = "1" and br_u_id = "'.$_SESSION['uid'].'" order by br_id desc';
$res = mysql_query($sql);
echo mysql_num_rows($res)."|";*/

$sql_Apprvd="SELECT count(*) AS count from buy_request where br_status = '1' and br_approval_status = '1' and br_expired_time >='".date("Y-m-d")."' and br_u_id = '".$_SESSION['uid']."'";
$res_Apprvd=mysql_query($sql_Apprvd);
$count_Apprvd=mysql_fetch_array($res_Apprvd);

$sql_pendAppr="SELECT count(*) AS count from buy_request where br_status = '1' and br_approval_status = '0' and br_expired_time >='".date("Y-m-d")."' and br_u_id = '".$_SESSION['uid']."'";
$res_pendAppr=mysql_query($sql_pendAppr);
$count_pendAppr=mysql_fetch_array($res_pendAppr);

$sql_expired="SELECT count(*) AS count from buy_request where br_status = '1' and br_expired_time < '".date("Y-m-d")."' and br_u_id = '".$_SESSION['uid']."'";
$res_expired=mysql_query($sql_expired);
$count_expired=mysql_fetch_array($res_expired);
?>

<div class="dpl-tabs">
	<div class="dpl-pagenav dpl-pagenav-right dpl-tabs-right clearfix" id="matrixTabPage">
			
		<?php
		// TO ENABLE THE NEXT BUTTON	
			if ($next_btn && $cur_page < $no_of_paginations)
			{
				$nex = $cur_page + 1;
		?>

        <span class="next" onclick="javascript:allProdTabBR('<?php echo $nex; ?>')"></span>
        <?php	}	else if ($next_btn)	{		?>
            <span class="next" style="opacity:0.4;"></span>
        <?php	}	
		
			// FOR ENABLING THE PREVIOUS BUTTON
			if($previous_btn && $cur_page > 1){
				$pre = $cur_page - 1;
		?>
			<span class="prev" onclick="javascript:allProdTabBR('<?php echo $pre; ?>')"></span>

		<?php	}else if($previous_btn){	?>
    		<span class="prev" style="opacity:0.4;"></span>
		<?php	}	?>
		
        <?php if($no_of_paginations>=1){ ?>
		<span style="visibility: visible;" class="hint"><?php echo $cur_page; ?>/<?php echo $no_of_paginations; ?></span>
        <?php } ?>
            
	</div>
	<ul class="clearfix" id="productTabs">
		<li class="current" id="allTab"><a href="javascript:allProdTabBR(1);"><span><?php echo $lang[428]; ?></span> (<span id="allCount"><?php echo $count; ?></span>)</a></li>
		<li id="approvedTab"><a href="javascript:approvedProdTabBR(1);"><span><?php echo $lang[480]; ?></span> (<span id="approvedCount"><?php echo $count_Apprvd['count']; ?></span>)</a></li>
		<li id="approvalPendingTab"><a href="javascript:pendingApprovalProdTabBR(1);"><span><?php echo $lang[481]; ?></span> (<span id="approvalPendingCount"><?php echo $count_pendAppr['count']; ?></span>)</a></li>
            <li id="expiredTab"><a href="javascript:expiredProdTabBR(1);"><span><?php echo $lang[48]; ?></span> (<span id="allCount"><?php echo $count_expired['count']; ?></span>)</a></li>
	</ul>
</div>

<form name="br_form" id="br_form" method="post">
  <div style="margin-bottom: 0pt;" class="listBatch ifm us en-us ff3 approved basic" id="listBatchTop">
    <div class="select" id="selectTop">      
     &nbsp;&nbsp;
      <input value="Batch Upload New Products" class="dpl-btn-gray-smaller dpl-font-black batchUploadBtn btn-add-batch" type="button">
      <input value="<?php echo $lang[169]; ?>" class="dpl-btn-gray-smaller dpl-font-black deleteBtn btn-del" id="btnDelete" name="btnDelete" type="submit" onClick="return deleteAll();">

      <div class="group-menu-container ddm-modify-display" id="matrixChangeDisplayGroupMenuTop"> <a href="javascript:;" onMouseOver="javascript:chngeDsplStatUB();" onMouseOut="javascript:chngeDsplStatUBout();" class="group-menu-trigger"><?php echo $lang[484]; ?></a> </div>
      <div style="display: none;left:483px;top:185px" id="chngDisplayUB" class="group-menu-panel" onMouseOver="chngeDsplStatUB();" onMouseOut="chngeDsplStatUBout();">
        <h5><?php echo $lang[484]; ?></h5>
        <ul>
          <li class="group-menu-item-wrapper"><a id="matrixChangeDisplayGroupMenuTop-group-menu-item-2" class="group-menu-item" href="javascript:chngeStatDisp(1);"><?php echo $lang[485]; ?></a></li>
          <li class="group-menu-item-wrapper"><a id="matrixChangeDisplayGroupMenuTop-group-menu-item-3" class="group-menu-item" href="javascript:chngeStatDisp(0);"><?php echo $lang[486]; ?></a></li>
        </ul>
      </div>
      
    </div>
  </div>
  
 
 <!------------------------------------------------List Of Posted Product By User------------------------------------------------------------------->
        
<!--<div style="border-top: medium none; display: none;" class="en-us" id="dataTableBatchUpload"></div>
<div style="border-top: medium none; display: none;" class="en-us" id="dataTableApprovalPending"></div>
<div style="border-top: medium none; display: none;" class="en-us" id="dataTableEditingRequired"></div>-->
<div style="border-top: medium none; display: block;" class="en-us AE-datatable" id="dataTableApproved"><div class="AE-datatable-head">
<table border="0" cellpadding="0" cellspacing="0" width="100%"><tbody>
<tr><th id="dataTableApproved_head_checkbox" class="matrix-column-checkbox dpl-th-left" width="20">
<input id="dataTableApproved_head_checkbox_checkbox" onClick = "return checkedAll();" type="checkbox" value=""></th>
<th id="dataTableApproved_head_image" class="matrix-column-image" width="70">
<span id="dataTableApproved_head_image_filter" class="datatable-head-filter-trigger"><?php echo $lang[475]; ?></span></th>
<th id="dataTableApproved_head_desc" class="matrix-column-subject" width="320"><span><?php echo $lang[491]; ?></span></th>
<th id="dataTableApproved_head_date" class="gmtModified" width="125">
<div id="dataTableApproved_head_date_sort" class="datatable-head-sort-desc" key="gmtModified" values="desc|asc" default="desc"><?php echo $lang[488]; ?></div></th>
<th id="dataTableApproved_head_status" class="status" width="115">
<span id="dataTableApproved_head_status_filter" class="datatable-head-filter-trigger"><?php echo $lang[489]; ?></span></th>
<th id="dataTableApproved_head_operate" class="operate dpl-th-right" width="60"><?php echo $lang[490]; ?></th></tr>
</tbody></table></div>




<div style="display: block;" class="AE-datatable-list AE-datatable-even mouseout" id="CenterDisp">
<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tbody>
<?php 
if(mysql_num_rows($result_pag_data)>0){
	while($row = mysql_fetch_object($result_pag_data)){
?>
<tr>
<td id="dataTableApproved_0_0" class="matrix-column-checkbox dpl-th-left AE-datatable-row-0 AE-datatable-col-0" width="20">
<input id="138697758" name="cb[]" type="checkbox" value="<?php echo $row->br_id; ?>" />
</td>
<td id="dataTableApproved_0_2" class="matrix-column-subject AE-datatable-row-0 AE-datatable-col-2" width="60">
<a class="stop-propagation" href="" title=""><?php echo stripslashes($row->br_pd_name); ?></a>
<br>
<span class="matrix-redModel"></span><br>
</td>
<td id="dataTableApproved_0_2" class="matrix-column-subject AE-datatable-row-0 AE-datatable-col-2" width="320">
<a class="stop-propagation" href="" title=""><?php echo $row->br_pd_spec; ?></a>
<br>
<span class="matrix-redModel"></span><br>

</td>
<td id="dataTableApproved_0_3" class="gmtModified AE-datatable-row-0 AE-datatable-col-3" width="125"><?php echo date('d M,Y',strtotime($row->br_updated_date)); ?></td>

<td id="dataTableApproved_0_4" class="status AE-datatable-row-0 AE-datatable-col-4" width="115">
<p><?php if($row->br_approval_status == '1'){echo $lang[480]; }else{ echo $lang[506];} ?></p>
<a title="<?php echo $lang[485]; ?>" style="display: inline;" href="javascript:showDisplyOpt(<?php echo $row->br_id; ?>);" class="matrix-dropdownlist" id='displayBrd<?php echo $row->br_id; ?>' width="100">
<?php if($row->br_display_status == '1'){echo $lang[485]; }else{ echo $lang[486];} ?>
</a>
<div id='optnListDisp<?php echo $row->br_id; ?>' class="matrix-dropdownlist-panel" style="width:80px;">
<h4><?php if($row->br_display_status == '1'){echo $lang[485];}else{ echo $lang[486];} ?><label style="cursor:pointer;padding-left:1.2px;padding-bottom:2px" onclick="javascript:hideDisplyOpt(<?php echo $row->br_id; ?>);"><img src="images/arrow_up_icon.jpg" /></label></h4>
<ul class="matrix-dropdownlist-panel-noTopBorder">
<li><a href="javascript:;" onClick="updtDispStat(<?php if($row->br_display_status == '1'){echo '0';}else{echo "1";} ?>,<?php echo $row->br_id; ?>);"><?php if($row->br_display_status == '0'){echo $lang[485];}else{ echo $lang[486];} ?></a></li>
</ul>
</div>
</td>
<script type="text/javascript">
function updtDispStat(status,br_id)
{
	jQuery.noConflict();
	jQuery.post("ajax-files/updateDisplayStatusBR.php", {status:status,br_id:br_id}, function(data){	window.location = "buying-request.php";	});
}
function showDisplyOpt(id){
	jQuery('#displayBrd'+id).hide();
	jQuery('#optnListDisp'+id).show();	
}
function hideDisplyOpt(id)
{
	jQuery('#displayBrd'+id).show();
	jQuery('#optnListDisp'+id).hide();
}
	
function delPostProduct(br_id)
{
	jQuery.noConflict();
	if(confirm("<?php echo $lang[492]; ?>"))
      {
	jQuery.post("ajax-files/delPostProductBR.php", {br_id:br_id}, function(data){	window.location = "buying-request.php";	});
      }
}	
</script>
<script type="text/javascript">
function arwDiv(id)
{
	jQuery('#arrow'+id).toggle();	
}
</script>
<td id="dataTableApproved_0_5" class="operate dpl-th-right AE-datatable-row-0 AE-datatable-col-5" width="60">
<a href="buy-request-edit.php?pid=<?php echo md5($row->br_id);?>" class="has-visited" target="_blank">
Edit</a>
<a href="javascript:arwDiv(<?php echo $row->br_id; ?>);" class="matrix-dropdownlist matrix-dropdownlist-arrow">&nbsp;</a>

<ul style="display: none;" id="arrow<?php echo $row->br_id; ?>" class="matrix-dropdownlist-panel matrix-dropdownlist-arrow-panel matrix-dropdownlist-show">
<li><a href="javascript:delPostProduct(<?php echo $row->br_id; ?>);"><?php echo $lang[169]; ?></a></li>
</ul>
</td></tr>
<?php }}else{ echo '<center style="color:red;font-weight:bolder">'.$lang[483].'</center>';} ?>
</tbody></table>
</div>
<!--------------------->
</div>

 <!------------------------------------------------List Of Posted Product By User------------------------------------------------------------------->
 
 
 
<div id="dataTableOnDisplay"></div>
<div id="dataTableNotOnDisplay"></div>
<div style="border-top: medium none; display: none;" class="en-us" id="dataTableSearchResult"></div>
<div style="display: none;" id="dataTableDraft"></div>
<div style="display: none;" id="loadingAvatar"></div>

<div class="listBatch ifm us en-us ff3 approved basic" id="listBatchBottom">
  <div class="select" id="selectBottom">
    <input style="display: inline;" id="footerCheckbox" onClick="return checkedAll();" type="checkbox">
    <input value="<?php echo $lang[169]; ?>" class="dpl-btn-gray-smaller dpl-font-black deleteBtn btn-del" type="submit" name="btnDelete" id="btnDelete" onClick="return deleteAll();">
    
		</div>
	</div>
	<div class="pageNav dpl-pagenav clearfix" id="paginator">
    
    <?php
	// FOR ENABLING THE PREVIOUS BUTTON
		if($previous_btn && $cur_page > 1){
				$pre = $cur_page - 1;
		?>
            <a class="AE-paginator-page" href="javascript:allProdTabBR('<?php echo $pre; ?>')">&lt;&lt;<?php echo $lang[248]; ?></a>

		<?php	}else if($previous_btn){	?>
            <a style="display:none;" class="AE-paginator-page" href="javascript:;')">&lt;&lt;<?php echo $lang[248]; ?></a>
		<?php	}
	
	
		for ($i = $start_loop; $i <= $end_loop; $i++) {
	    	if($cur_page == $i){	?>
	        <a class="AE-paginator-page current"><?php echo $i; ?></a>
	<?php	} else	{	?>
			<a class="AE-paginator-page" href="javascript:allProdTabBR('<?php echo $i; ?>')"><?php echo $i; ?></a>
	<?php	}
		}
		
		// TO ENABLE THE NEXT BUTTON	
			if ($next_btn && $cur_page < $no_of_paginations)
			{
				$nex = $cur_page + 1;
		?>
	        <a class="AE-paginator-page" href="javascript:allProdTabBR('<?php echo $nex; ?>')"><?php echo $lang[249]; ?>&gt;&gt;</a>
        <?php	}	else if ($next_btn)	{		?>
            <a style="display: none;" class="AE-paginator-page" href="javascript:;"><?php echo $lang[249]; ?>&gt;&gt;</a>
        <?php	}	?>
    
    </div>

</form>	


<?php	}	?>