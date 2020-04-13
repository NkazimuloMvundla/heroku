<?php
ob_start();
session_start();
include "../common.php";

$uid=$_GET['id'];
$sql="select * from temp_attach_file where taf_u_id='".$uid."'";
$res=mysql_query($sql);
if(mysql_num_rows($res)>0)
{
	while($row=mysql_fetch_object($res)){	?>
	<div class="uploadifive-queue-item">
		
        <div style="height:10px;width:400px;">
        	<span class="filename"><?php echo $row->taf_file; ?></span>
            <span class="fileinfo">&nbsp;</span>
            <span class="fileinfo">&nbsp;</span>
            <span class="fileinfo"><a class="close" href="javascript:del_temp_attachment('<?php echo $row->taf_id; ?>')">X</a></span>
		</div>
    </div>	
<?php	}
}
else
{	?>
		<!--<div class="uploadifive-queue-item"><div style="color:#F00"><span class="filename">File not uploaded successfully. Please try again.</span></div></div>-->
	
<?php	}	?>