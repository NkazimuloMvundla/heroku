<?php
include "../common.php";
?>

<div id="maLeftNavigator" class="menu menuSkinA">
	<div class="menu-main">
		<ul id="group">
           	<input type="button" value="Add Group" class="ui-button ui-button-normal-s" style="padding-left:1px;padding-right:1px;" onClick="addNewGroup();"/>
            <input type="button" value="<?php echo $lang[169]; ?>" class="ui-button ui-button-normal-s" style="padding-left:1px;padding-right:1px;" onclick="delGroup();" id="btnDelGroup" disabled="disabled"/>
            <input type="button" value="Rename" class="ui-button ui-button-normal-s" style="padding-left:1px;padding-right:1px;" onclick="renameGroup()" id="btnRenameGroup" disabled="disabled"/>
            <input type="hidden" id="current_pg" value="" />
            <li id="gr_0"><a style="cursor:pointer;text-decoration:none;" onClick="showPhoto(1,0);"><?php echo $lang[496]; ?></a></li>  
            <?php 
			$sql_pg="select * from photo_group where pg_u_id='".$_SESSION['uid']."' and pg_status='1'";
			$res_pg=mysql_query($sql_pg);
			while($row_pg=mysql_fetch_object($res_pg)){	?>
			<li id="gr_<?php echo $row_pg->pg_id; ?>"><a style="cursor:pointer; text-decoration:none;" onClick="showPhoto(1,<?php echo $row_pg->pg_id; ?>);"><?php echo $row_pg->pg_name; ?></a>
            		<span id="rename_group_<?php echo $row_pg->pg_id; ?>" style="display:none;">
            <input type="text" id="pg_name_<?php echo $row_pg->pg_id; ?>" name="pg_name_<?php echo $row_pg->pg_id; ?>" value="<?php echo $row_pg->pg_name; ?>" style="width:80px;margin-left:10px;height:15px;"/><input type="button" value="<?php echo $lang[364]; ?>" class="ui-button ui-button-normal-s" style="padding-left:1px;padding-right:1px;" onClick="saveGroupName(<?php echo $row_pg->pg_id; ?>);" />
            </span>        
                 </li>	
		<?php	}	?>
       	</ul>
            <span id="new_group" style="display:none;">
            <input type="text" id="pg_name" name="pg_name" style="width:80px;margin-left:10px;height:15px;"/><input type="button" value="<?php echo $lang[364]; ?>" class="ui-button ui-button-normal-s" onClick="saveNewGroup();" />
            </span>
            

    	</div>
    </div>