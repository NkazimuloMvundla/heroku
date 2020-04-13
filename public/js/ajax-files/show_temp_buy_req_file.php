<?php
ob_start();
//session_start();
include "../common.php";

$uid=$_GET['u'];
$sql= "SELECT * FROM temp_buy_req_file  WHERE tf_uid = ? ";
$stmt= $pdo->prepare($sql);
$stmt->bindValue(1, $uid,PDO::PARAM_INT);
$stmt->execute();
if($stmt->rowCount()>0)
{
	while($row=$stmt->fetch(PDO::OBJ)){	?>
	<div class="uploadifive-queue-item">
		
        <div style="height:10px;">
        	<span class="filename"><?php echo $row->tf_fileName; ?></span>
           <!-- <span class="fileinfo"> - </span>
            <span class="fileinfo">Completed</span>-->
            <span class="fileinfo"><a class="close" href="javascript:delTempBuyReqFiles('<?php echo $row->tf_id; ?>')">X</a></span>
		</div>
    </div>	
<?php	}
}
else
{	?>
		<!--<div class="uploadifive-queue-item"><div style="color:#F00"><span class="filename">File not uploaded successfully. Please try again.</span></div></div>-->
	
<?php	}	?>