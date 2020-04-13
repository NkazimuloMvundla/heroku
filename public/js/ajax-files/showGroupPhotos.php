<?php
include '../common.php';
date_default_timezone_set('UTC');

if($_POST['page'])
{
$page = $_POST['page'];
$pg_id=$_POST['id'];
$cur_page = $page;
$page -= 1;
$per_page = 10; // Per page records
$previous_btn = true;
$next_btn = true;
//$first_btn = false;
//$last_btn = false;
$start = $page * $per_page;
	
$query_pag_data = "select * from photo where ph_status = '1' and ph_u_id = '".$_SESSION['uid']."' and ph_pg_id='".$pg_id."' order by ph_id desc LIMIT $start, $per_page";
$result_pag_data = mysql_query($query_pag_data) or die('MySql Error' . mysql_error());

/* -----Total count--- */
$query_pag_num = "SELECT count(*) AS count from photo where ph_status = '1' and ph_u_id = '".$_SESSION['uid']."' and ph_pg_id='".$pg_id."'"; // Total records

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
//$sql = 'select * from product where pd_status = "1" and pd_u_id = "'.$_SESSION['uid'].'" order by pd_id desc';
//$res = mysql_query($sql);
//echo mysql_num_rows($res)."|";

/*$sql_Apprvd="SELECT count(*) AS count from product where pd_status = '1' and pd_approval_status = '1' and pd_expiry_date >= '".date("Y-m-d")."' and pd_u_id = '".$_SESSION['uid']."'";
$res_Apprvd=mysql_query($sql_Apprvd);
$count_Apprvd=mysql_fetch_array($res_Apprvd);

$sql_pendAppr="SELECT count(*) AS count from product where pd_status = '1' and pd_approval_status = '0' and pd_expiry_date >= '".date("Y-m-d")."' and pd_u_id = '".$_SESSION['uid']."'";
$res_pendAppr=mysql_query($sql_pendAppr);
$count_pendAppr=mysql_fetch_array($res_pendAppr);*/
?>

<div class="dpl-tabs">
		<div class="dpl-pagenav dpl-pagenav-right dpl-tabs-right clearfix" id="matrixTabPage">
			
		<?php
		// TO ENABLE THE NEXT BUTTON	
			if ($next_btn && $cur_page < $no_of_paginations)
			{
				$nex = $cur_page + 1;
		?>

        <span class="next" onclick="javascript:showPhoto('<?php echo $nex; ?>','<?php echo $pg_id; ?>')"></span>
        <?php	}	else if ($next_btn)	{		?>
            <span class="next" style="opacity:0.4;"></span>
        <?php	}	
		
			// FOR ENABLING THE PREVIOUS BUTTON
			if($previous_btn && $cur_page > 1){
				$pre = $cur_page - 1;
		?>
			<span class="prev" onclick="javascript:showPhoto('<?php echo $pre; ?>','<?php echo $pg_id; ?>')"></span>

		<?php	}else if($previous_btn){	?>
    		<span class="prev" style="opacity:0.4;"></span>
		<?php	}	?>
			
			<span style="visibility: visible;" class="hint"><?php if($no_of_paginations>0){ echo $cur_page; ?>/<?php echo $no_of_paginations; } ?></span>
            
		</div>
		<ul class="clearfix" id="productTabs">
			<li class="current" id="allTab"><a onclick="javascript:allProdTab(1);"><span><?php echo $lang[428]; ?></span> (<span id="allCount"><?php echo $count; ?></span>)</a></li>


		</ul>
	</div>

<form name="mp_form" id="mp_form" method="post">
		<div style="margin-bottom: 0pt;" class="listBatch ifm us en-us ff3 approved basic" id="listBatchTop">
			<div class="select" id="selectTop"> 
				&nbsp;&nbsp;
				<input value="<?php echo $lang[169]; ?>" class="dpl-btn-gray-smaller dpl-font-black deleteBtn btn-del" id="btnDelete" name="btnDelete" type="button" onClick="deleteAll();"/>

		</div>
	</div>
  
	<div style="border-top: medium none; display: block;" class="en-us AE-datatable" id="dataTableApproved">
    	<div class="AE-datatable-head">
			<table border="0" cellpadding="0" cellspacing="0" width="100%"><tbody>
				<tr>
                	<th id="dataTableApproved_head_checkbox" class="matrix-column-checkbox dpl-th-left" width="20">
						<input id="dataTableApproved_head_checkbox_checkbox" onClick = "return checkedAll();" type="checkbox" value="">
                    </th>
					<th id="dataTableApproved_head_image" class="matrix-column-image" width="85">
						<span id="dataTableApproved_head_image_filter" class="datatable-head-filter-trigger"><?php echo $lang[518]; ?></span>
                    </th>
					<th id="dataTableApproved_head_desc" class="matrix-column-subject" width="320"><span>&nbsp;</span></th>
					<th id="dataTableApproved_head_date" class="gmtModified dpl-th-right" width="125">
						<div id="dataTableApproved_head_date_sort" class="datatable-head-sort-desc" key="gmtModified" values="desc|asc" default="desc"><?php echo $lang[488]; ?></div>
                    </th>
					

			</tr>
			</tbody></table>
		</div>


<!--------------------------------->
<div style="display: block;" class="AE-datatable-list AE-datatable-even mouseout" id="CenterDisp">
<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tbody>
<?php 
if(mysql_num_rows($result_pag_data)>0){
	while($row = mysql_fetch_object($result_pag_data)){
?>
<tr>
<td id="dataTableApproved_0_0" class="matrix-column-checkbox dpl-th-left AE-datatable-row-0 AE-datatable-col-0" width="20">
<input id="138697758" name="cb[]" type="checkbox" value="<?php echo $row->ph_id; ?>">
</td>
<td id="dataTableApproved_0_1" class="matrix-column-image AE-datatable-row-0 AE-datatable-col-1" width="85">
<a class="matrix-product-pics">
<img src="upload/product_image/140x139/<?php echo $row->ph_fileName; ?>" alt="" height="50" width="50"></a>
</td>
<td id="dataTableApproved_0_2" class="matrix-column-subject AE-datatable-row-0 AE-datatable-col-2" width="320">
<a class="stop-propagation" href="" title="dessx"><?php // echo stripslashes($row->pd_name); ?></a>
<br>
<span class="matrix-redModel"></span><br>
</td>
<td id="dataTableApproved_0_3" class="gmtModified AE-datatable-row-0 AE-datatable-col-3" width="125"><?php echo date('d M,Y',strtotime($row->ph_updated_date)); ?></td>


<script type="text/javascript">
function updtDispStat(status,pd_id)
{
	jQuery.noConflict();
	jQuery.post("ajax-files/updateDisplayStatus.php", {status:status,pd_id:pd_id}, function(data){	window.location = "manage-products.php";	});
}
function showDisplyOpt(id)
{
	jQuery('#displayBrd'+id).hide();
	jQuery('#optnListDisp'+id).show();	
}
function hideDisplyOpt(id){
	jQuery('#displayBrd'+id).show();
	jQuery('#optnListDisp'+id).hide();
	}
	
function delPostProduct(pd_id){
	jQuery.noConflict();
	if(confirm("<?php echo $lang[492]; ?>"))
      {
	jQuery.post("ajax-files/delPostProduct.php", {pd_id:pd_id}, function(data){	window.location = "manage-products.php";	});
      }
}	
</script>
<script type="text/javascript">
function arwDiv(id){
	jQuery('#arrow'+id).toggle();	
	}
</script>
</tr>
<?php }}else{ echo '<center style="color:red;font-weight:bolder">'.$lang[483].'</center>';} ?>
</tbody></table>
</div>

<!--------------------------------->

</div>

 <!------------------------------------------------List Of Posted Product By User------------------------------------------------------------------->
 
	<div class="listBatch ifm us en-us ff3 approved basic" id="listBatchBottom">
		<div class="select" id="selectBottom">
			<input style="display: inline;" id="footerCheckbox" onClick="return checkedAll();" type="checkbox">
			<input value="<?php echo $lang[169]; ?>" class="dpl-btn-gray-smaller dpl-font-black deleteBtn btn-del" type="button" name="btnDelete" id="btnDelete" onClick="deleteAll();">
		</div>
	</div>
    <div class="pageNav dpl-pagenav clearfix" id="paginator">
    
    <?php
	// FOR ENABLING THE PREVIOUS BUTTON
		if($previous_btn && $cur_page > 1){
				$pre = $cur_page - 1;
		?>
            <a class="AE-paginator-page" href="javascript:showPhoto('<?php echo $pre; ?>','<?php echo $pg_id; ?>')">&lt;&lt;<?php echo $lang[248]; ?></a>

		<?php	}else if($previous_btn){	?>
            <a style="display:none;" class="AE-paginator-page" href="javascript:;')">&lt;&lt;<?php echo $lang[248]; ?></a>
		<?php	}
	
	
		for ($i = $start_loop; $i <= $end_loop; $i++) {
	    	if($cur_page == $i){	?>
	        <a class="AE-paginator-page current"><?php echo $i; ?></a>
	<?php	} else	{	?>
			<a class="AE-paginator-page" href="javascript:showPhoto('<?php echo $i; ?>','<?php echo $pg_id; ?>')"><?php echo $i; ?></a>
	<?php	}
		}
		
		// TO ENABLE THE NEXT BUTTON	
			if ($next_btn && $cur_page < $no_of_paginations)
			{
				$nex = $cur_page + 1;
		?>
	        <a class="AE-paginator-page" href="javascript:showPhoto('<?php echo $nex; ?>','<?php echo $pg_id; ?>')"><?php echo $lang[249]; ?>&gt;&gt;</a>
        <?php	}	else if ($next_btn)	{		?>
            <a style="display: none;" class="AE-paginator-page" href="javascript:;"><?php echo $lang[249]; ?>&gt;&gt;</a>
        <?php	}	?>
    
        
    </div>
</form>

<?php	}	?>