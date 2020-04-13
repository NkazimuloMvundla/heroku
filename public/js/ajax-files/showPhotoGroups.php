<?php

$sql_pg="select * from photo_group where pg_u_id='".$_SESSION['uid']."' and pg_status='1'";
$res_pg=mysql_query($sql_pg);
?>

<div id="photoBankGroupList">
	<div class="groupList">
		<div id="btnShowAllGroup" class="groupTitle" onclick="showPhotos(1,-1);"><?php echo $lang[522]; ?></div>
		<div style="display: block; overflow: hidden; height: auto;" id="groupTreeContainer">
			<ol class="AE-treeview-root">
            <?php	while($row_pg=mysql_fetch_object($res_pg)){	?>
				<li class="AE-treeview-root-li AE-treeview-0-0"><a class="AE-treeview-root-item clear AE-treeview-alone" onClick="showPhotos(1,<?php echo $row_pg->pg_id; ?>);" id="gr-<?php echo $row_pg->pg_id; ?>"><span class="AE-treeview-anchor"></span><span title="Test Group" class="AE-treeview-label"><?php echo $row_pg->pg_name; ?></span></a></li>
                <?php	}	?>
				<li class="AE-treeview-root-li AE-treeview-0-1"><a class="AE-treeview-root-item clear AE-treeview-alone" onClick="showPhotos(1,0);" id="gr-0"><span class="AE-treeview-anchor"></span><span title="<?php echo $lang[523]; ?>" class="AE-treeview-label"><?php echo $lang[523]; ?></span></a></li>
			</ol>
		</div>
	</div>
</div>