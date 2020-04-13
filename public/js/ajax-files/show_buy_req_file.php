<?php
ob_start();
include "../common.php";

$br_id=$_GET['id'];
$sql="select * from buy_req_file where brf_br_id='".$br_id."'";
$res=mysql_query($sql);
if(mysql_num_rows($res)>0)
{
	while($row=mysql_fetch_object($res)){	?>
	<div class="uploadifive-queue-item">
		
        <div style="height:10px;width:400px;">
        	<span class="filename"><?php echo $row->brf_fileName; ?></span>
            <span class="fileinfo">&nbsp;</span>
            <span class="fileinfo">&nbsp;</span>
            <span class="fileinfo"><a class="close" href="javascript:delBuyReqFiles('<?php echo $row->brf_id; ?>')">X</a></span>
		</div>
    </div>	
<?php	}
}
else
{	?>
		<!--<div class="uploadifive-queue-item"><div style="color:#F00"><span class="filename">File not uploaded successfully. Please try again.</span></div></div>-->
	
<?php	}	?>