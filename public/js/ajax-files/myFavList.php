<?php
include "../common.php";
$sql = "select * from user, my_favorite, product,currency, measurement_unit where u_id=pd_u_id and mf_pd_id=pd_id and cur_id=pd_cur_id and mu_id =pd_fob_mu_id and mf_u_id = '".$_SESSION['uid']."'";
$res = mysql_query($sql);
if(mysql_num_rows($res)>0){
?>
<div class="mainWrap">
<ul id="list" class="list">
<?php
while($row = mysql_fetch_object($res)){
?>
<li style="border-color: rgb(238, 238, 238);" class="item">

<div class="itemInner">
	<div class="photo">
	<a href="" target="_blank">
          <img class="favImg" src="upload/product_image/250x250/<?php echo $row->pd_photo?>" alt="<?php echo stripslashes($row->pd_name); ?>" border="0"></a>
	</div>
	<div class="detail2">
		<?php
			$sql_supp = "select * from company_profile where cp_u_id = '".$row->pd_u_id."'";
			$res_supp = mysql_query($sql_supp);
		?>
	<div class="contactsupp">
		<?php if(!(isset($_SESSION['uid']) && $_SESSION['uid']==$row->pd_u_id)){ ?>
		<a class="contact" target="_blank" href="contact-supplier.php?p=<?php echo md5($row->pd_id); ?>"><?php echo $lang[361]; ?></a>
            <?php } ?>
            <?php if(mysql_num_rows($res_supp)>0){ 
            $row_supp = mysql_fetch_object($res_supp);
            ?>
		<a class="supplier" target="_blank" href="supplier.php?s=<?php echo md5($row_supp->cp_id);?>&ucheck=<?php echo 'loadcontact' ;?>"><?php echo $lang[370]; ?></a>
            <?php } ?>
		
	</div>
		<div class="priord">
			<div>
            <?php
			$row_cur = mysql_fetch_object(mysql_query('select * from currency where cur_id = "'.$row->pd_cur_id.'"'));
			$row_mu = mysql_fetch_object(mysql_query('select * from measurement_unit where mu_id = "'.$row->pd_fob_mu_id.'"'));
			?>
            <nobr><?php echo $lang[183]; ?> </nobr> <nobr><span class="price"><?php echo $row_cur->cur_symbol.' '.$row->pd_fob_min_price.' - '.$row->pd_fob_max_price.'/'.$row_mu->mu_name; ?>  </span></nobr></div>
			<div><nobr><?php echo $lang[514]; ?></nobr> <nobr><span class="order"><?php echo $row->pd_port;  ?></span></nobr></div>
			<div><nobr><?php echo $lang[246]; ?></nobr> <nobr><span class="order"><?php echo $row->pd_min_order_qty;  ?></span></nobr></div>
						
			
		</div>
				
	</div>
	<div class="detail" id="111264438">
		 			<a href="product.php?p=<?php echo md5($row->pd_id); ?>" target="_blank" class="summary" onmousedown="trackFavorite({entrance: 'all_tab_product'});"><?php echo stripslashes($row->pd_name);?></a>
		<br>
		<span class="corporation">
         			<a href="" target="_blank" onmousedown="trackFavorite({entrance: 'all_tab_product_company'});"><?php echo $row->u_companyName;?></a>
        </span>
        <?php
        $row_ct = mysql_fetch_object(mysql_query("select * from city where ct_id = '".$row->u_ct_id."'"));
		$row_cn = mysql_fetch_object(mysql_query("select * from country where cn_id = '".$row_ct->ct_cn_id."'"));
		?>
		<span class="region">[<?php echo $row_cn->cn_name; ?>]</span>
        <script type="text/javascript">
        function showCommentBox(id){
				jQuery("#commentArea"+id).show();
				jQuery('#addNote_'+id).hide();
						   
		}
		function cancelComment(id)
		{		
			jQuery("#commentArea"+id).hide();
			jQuery('#addNote_'+id).show();
		}
			
		function saveComment(uid,pid)
		{
			jQuery.noConflict();
			var favComment = jQuery("#favComment"+pid).val();

			jQuery.post(
					"ajax-files/addFavComment.php", 
        			{favComment:favComment,uid:uid,pid:pid}, 
         				function(data){
							window.location = "my-favorite.php";
						
        });
		}
		function UpdtCmmntLabel(id){
			jQuery("#commentDiv"+id).hide();
			jQuery('#UpdtCommentArea'+id).show();
		}
		function cancelCommentUpdt(id){
			jQuery("#commentDiv"+id).show();
			jQuery('#UpdtCommentArea'+id).hide();
		}
		function UpdtComment(cid){
			jQuery.noConflict();
			var favCommentUpdt = jQuery("#favCommentUpdt"+cid).val();

			jQuery.post(
					"ajax-files/UpdtFavComment.php", 
        			{favCommentUpdt:favCommentUpdt,cid:cid}, 
         				function(data){//alert(data)
							window.location = "my-favorite.php";
						
        });
			}
        </script>
        <?php
		$sql_cmmnt = 'select * from my_fav_comment where mfc_pd_id = "'.$row->pd_id.'"';
		$res_cmmnt = mysql_query($sql_cmmnt);
		$row_cmmnt = mysql_fetch_object($res_cmmnt);
		if(mysql_num_rows($res_cmmnt)==0)
		{?>
        <a class="addNote" id="addNote_<?php echo $row->pd_id;?>" href="javascript:showCommentBox(<?php echo $row->pd_id;?>);"><?php echo $lang[362]; ?></a>
        <?php }else{ ?>	
        <div id="commentDiv<?php echo $row->pd_id;?>" style="background-color: #FFC;width:470px;height:30px">
        <table><tr>
        <td style="width:10px"></td>
        <td>
        <?php echo $row_cmmnt->mfc_comment; ?>&nbsp;&nbsp;
        <small style="color:#00F;cursor:pointer"><a href="javascript:UpdtCmmntLabel(<?php echo $row->pd_id;?>);"><?php echo $lang[363]; ?></a></small>
        </td>
        </tr></table>
        </div>	
		<?php } ?>	
		<label style="display:none" id="UpdtCommentArea<?php echo $row->pd_id;?>">
        <table><tr><td>
        <textarea id="favCommentUpdt<?php echo $row_cmmnt->mfc_id;?>" name="favCommentUpdt<?php echo $row_cmmnt->mfc_id;?>" rows="4" cols="60"><?php echo $row_cmmnt->mfc_comment; ?></textarea>
        </td>
        <td>
        <span style="cursor:pointer"><a href="javascript:UpdtComment(<?php echo $row_cmmnt->mfc_id;?>);"><?php echo $lang[364]; ?></a><br/><a href="javascript:cancelCommentUpdt(<?php echo $row->pd_id;?>);"><?php echo $lang[365]; ?></a></span>
        </td></tr>
        </table>
        </label>	
        <label style="display:none" id="commentArea<?php echo $row->pd_id;?>">
        <table><tr><td>
        <textarea id="favComment<?php echo $row->pd_id;?>" name="favComment<?php echo $row->pd_id;?>" rows="4" cols="60"></textarea>
        </td>
        <td>
        <span style="cursor:pointer"><a href="javascript:saveComment(<?php echo $_SESSION['uid'].','.$row->pd_id;?>);">ok</a><br/><a href="javascript:cancelComment(<?php echo $row->pd_id;?>);"><?php echo $lang[365]; ?></a></span>
        </td></tr>
        </table>
        </label>
        </div>
	<div class="attribute"> 
		<span style="display: block;" class="time"><?php echo $lang[366]; ?> <?php echo date('d M,Y',strtotime($row->mf_updated_date)).' '.date('h:i a',strtotime($row->mf_updated_date)); ?></span>
		
			</div>
	<input isdelete="false" id="chkboxItem_136680494" objecttype="product" name="cb[]" class="chkbox" value="<?php echo $row->mf_id; ?>" type="checkbox">
</div>
														
</li>
<?php }?>
</ul>

</div>
<?php }else{?>
                        
     <!------------------------------------------------------------>  
<div class="mainWrap">
<div class="defaultWrap">                      
                        
</div>
</div>					
                        
<?php } ?>