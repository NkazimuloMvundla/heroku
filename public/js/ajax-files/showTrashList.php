<?php
include '../common.php';
$sql = 'select * from product where pd_status = "0" and pd_u_id = "'.$_SESSION['uid'].'" order by pd_id desc';
$res = mysql_query($sql);
echo mysql_num_rows($res)."|";
?>
<div style="display: block;" class="AE-datatable-list AE-datatable-even mouseout" id="CenterDisp">
<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tbody>
<?php 
if(mysql_num_rows($res)>0){
	while($row = mysql_fetch_object($res)){
?>
<tr>
<td id="dataTableApproved_0_0" class="matrix-column-checkbox dpl-th-left AE-datatable-row-0 AE-datatable-col-0" width="47">
<input id="138697758" name="cb[]" type="checkbox" value="<?php echo $row->pd_id; ?>">
</td>
<td id="dataTableApproved_0_1" class="matrix-column-image AE-datatable-row-0 AE-datatable-col-1" width="200">
<a href="product.php?p=<?php echo md5($row->pd_id); ?>" class="matrix-product-pics">
<img src="upload/product_image/250x250/<?php echo $row->pd_photo; ?>" alt="" height="50" width="50"></a>
</td>
<td id="dataTableApproved_0_2" class="matrix-column-subject AE-datatable-row-0 AE-datatable-col-2" width="627">
<a class="stop-propagation" href="" title=""><?php echo stripslashes($row->pd_name); ?></a>
<br>
<span class="matrix-redModel"></span><br>
<!--<span class="matrix-group-level" title="ungrouped">Group: ungrouped</span>-->
</td>
<td id="dataTableApproved_0_3" class="gmtModified AE-datatable-row-0 AE-datatable-col-3" width="426"><?php echo date('d M,Y',strtotime($row->pd_updated_date)); ?></td>


</tr>
<?php }}else{ echo '<center style="color:red;font-weight:bolder">'.$lang[483].'</center>';} ?>
</tbody></table>
</div>