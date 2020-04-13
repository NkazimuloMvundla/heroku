<?php
include '../common.php';

if($_POST['page'])
{
$page = $_POST['page'];
$pg_id=$_POST['id'];
$cur_page = $page;
$page -= 1;
$per_page = 18; // Per page records
$previous_btn = true;
$next_btn = true;
//$first_btn = false;
//$last_btn = false;
$start = $page * $per_page;

if($pg_id >= 0)
{
	$query_pag_data = "select * from photo where ph_status = '1' and ph_u_id = '".$_SESSION['uid']."' and ph_pg_id='".$pg_id."' order by ph_id desc LIMIT $start, $per_page";
}
else
{
	$query_pag_data = "select * from photo where ph_status = '1' and ph_u_id = '".$_SESSION['uid']."' order by ph_id desc LIMIT $start, $per_page";
}

$result_pag_data = mysql_query($query_pag_data) or die('MySql Error' . mysql_error());

/* -----Total count--- */
if($pg_id >= 0)
{
	$query_pag_num = "SELECT count(*) AS count from photo where ph_status = '1' and ph_u_id = '".$_SESSION['uid']."' and ph_pg_id='".$pg_id."'"; // Total records
}
else
{
	$query_pag_num = "SELECT count(*) AS count from photo where ph_status = '1' and ph_u_id = '".$_SESSION['uid']."'"; // Total records
}

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

/******************************************************/

?>

<div class="pic-action">
<!--<button id="btnAddTo" class="ui-button ui-button-primary-s">Use this Photo</button>--><strong><?php echo $lang[378]; ?></strong> <?php echo $lang[379]; ?></div>
			
			<div id="photoBankPhotoList" class="photo-grid-view">
				<div id="photoBankPhotoListTip" style="display:none;"></div>
				<ul class="displayblock">
                <?php 
					if(mysql_num_rows($result_pag_data)>0){
						$i=0;
					while($row = mysql_fetch_object($result_pag_data)){
				?>
					<li class="photo-0 <?php if($i%2==0){ ?>evel <?php }else{ ?>odd <?php } ?> displayblock photo-hidden">
                       	<div class="photo-operate clear photo-hidden">
	                       <!-- <label class="checkboxLabel" for="chkSelectPhoto"><input class="photo-checkbox" value="" type="checkbox"></label>-->
                            <a class="btn-list-apply" href="javascript:usePhoto(<?php echo $row->ph_id; ?>)" title="<?php echo $lang[380]; ?>"><?php echo $lang[380]; ?></a>
                            <!--<a class="btn-list-detail" href="javascript:void(0)" title="View Details">View Details</a>-->
                        </div>
                        <div class="photo-preview clear">
                           	<div class="image-container"><img src="upload/product_image/140x139/<?php echo $row->ph_fileName; ?>" class="photo-thumbnail" title="<?php echo $row->ph_fileName; ?>" alt="<?php echo $row->ph_fileName; ?>" width="96" height="96" ondblclick="javascript:usePhoto(<?php echo $row->ph_id; ?>)"/></div>
                        </div>
                        <div class="photo-name ">
                           	<span class="photo-title" title="<?php echo $row->ph_fileName; ?>"><?php echo $row->ph_fileName; ?></span>
                        </div>
                        <!--<div class="photo-size">57.39KB</div>-->
                        <div class="photo-lastUpdate"><?php echo $row->ph_updated_date; ?></div>
					</li>
                <?php	}
					}
				?>    
					
				</ul>
			</div>
				<div id="photoGridTemplate" style="display:none;"></div>
				<div id="photoMoveToGroup" style="display:none;"></div>
				<div class="displayblock AE-paginator" id="photoPagination">
        <?php
		// FOR ENABLING THE PREVIOUS BUTTON
		if($previous_btn && $cur_page > 1){
				$pre = $cur_page - 1;
		?>
			<a href="javascript:showPhotos(<?php echo $pre; ?>,<?php echo $pg_id; ?>);"><span class="AE-paginator-page">&lt;&lt; <?php echo $lang[251]; ?></span></a>
		<?php	}else if($previous_btn){	?>
            <span class="AE-paginator-page AE-paginator-current">&lt;&lt; <?php echo $lang[251]; ?></span>
		<?php	}	?>

		<?php
			for ($i = $start_loop; $i <= $end_loop; $i++) {
		    	if($cur_page == $i){	?>
                <span style="" class="AE-paginator-page AE-paginator-current"><?php echo $i; ?></span>
		<?php	} else	{	?>
			<a href="javascript:showPhotos('<?php echo $i; ?>','<?php echo $pg_id; ?>')"><span style="" class="AE-paginator-page"><?php echo $i; ?></span></a>
		<?php	}
		}
		?>
					<!--<span style="display: none;" class="AE-paginator-ellipsis">...</span>
					<span style="display: none;" class="AE-paginator-ellipsis">...</span>-->
		<?php
            // TO ENABLE THE NEXT BUTTON	
			if ($next_btn && $cur_page < $no_of_paginations)
			{
				$nex = $cur_page + 1;
		?>
            <a href="javascript:showPhotos(<?php echo $nex; ?>,<?php echo $pg_id; ?>);"><span class="AE-paginator-page"><?php echo $lang[249]; ?> &gt;&gt;</span></a>
        <?php	}	else if ($next_btn)	{		?>
            <span class="AE-paginator-page AE-paginator-current"><?php echo $lang[249]; ?> &gt;&gt;</span>
        <?php	}	?>
                    <!--<span><input size="3" type="text" id="pht_page_no"><input value="Go" type="button"></span>-->
                </div>
<?php	}	?>