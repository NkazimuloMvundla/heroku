<?php
include '../common.php';
$mid = $_POST['mid'];
$sql = 'select * from message where msg_id = "'.$mid.'"';
$res = mysql_query($sql);
$row = mysql_fetch_object($res);
?>
<script type="text/javascript" src="js/jquery-1.2.1.min.js"></script>
<script>
function usePhoto(id)
{
//	alert(id);
	$.post("ajax-files/upl_temp_image_from_phbank.php", {id:id}, function(data){	
		parent.jQuery.colorbox.close();
            show_temp_attachment(<?php echo $_SESSION['uid']; ?>);
		//$("#picSingleItemTemplateRind").html('<img src="images/loader.gif" alt="Uploading...." height="100" width="100"/>');
		
//		setTimeout(function (){

//		show_temp_photo(<?php //echo $_SESSION['uid']; ?>);

  //       }, 500);
		

	});
}  
</script>
<div class="allin-toolbar util-clearfix" id="composeTopBar">
     <div node="98" class="option-list list">
      <a title="<?php echo $lang[127]; ?>" store="45" data-id="send" node="99" class="allin-toolbar-btn" href="javascript:sendMsg();">
           	<span node="103" class="allin-icon icon-send"></span>
            <span class="allin-text"><?php echo $lang[127]; ?></span>
	</a>
<!--  <a title="Save As Template" store="46" data-id="saveTemplate" node="100" class="allin-toolbar-btn"><span node="104" class="allin-icon icon-set-mail-temp"></span><span class="allin-text">Save As Template</span></a>-->
<a title="<?php echo $lang[365]; ?>" store="47" data-id="concel" node="101" class="allin-toolbar-btn"  onClick="javascript:closeReply()">
                	<span node="105" class="allin-icon icon-cancel"></span>
                    <span class="allin-text"><?php echo $lang[365]; ?></span>
				</a>
<!--                <a title="Translation Tool" store="48" data-id="translateTool" node="102" class="allin-toolbar-btn"><span node="106" class="allin-icon icon-translate"></span><span class="allin-text">Translation Tool</span></a>-->
			</div>
		</div>
    
    <div id="compose-wrap" class="m-send" style="">
    <center><label id='res' style="color:#F00"></label></center>
    <form id="compose-form" onSubmit="return false" class="allin-form">
        
        <div class="allin-form-item">
            <label id="to-label" class="allin-form-label"><?php echo $lang[497]; ?></label>
            <div class="allin-form-input allin-send-hint">
                <div class="allin-form-input-wrap" id="tos-contant">
                	<div id="83" style="left: 0px; top: 0px; z-index: 10; display: none; position: absolute; max-height: 200px;" class="widget-list-master ">
		                <div id="list-body-83" style="-moz-user-select:none;" class="widget-list-body "></div>
                    </div>
                    <div id="82" style="outline: medium none;" tabindex="0" hidefocus="true" class="widget-addr-master clearfix ">
                         <?php
                         $sql_user = 'select * from user where u_id = "'.$row->msg_from_id.'"';
						 $res_user = mysql_query($sql_user);
						 $row_user = mysql_fetch_object($res_user);
						 echo $row_user->u_email;
						 ?>
	                   
                    	</div>
                    <input type="hidden" id="msg_to_id" name="msg_to_id" value="<?php echo $row->msg_from_id; ?>"/>
				</div>
                <div id="contactSelectorDiv" class="allin-contact-selector allin-window"></div>
            </div>
        </div>
        <div class="allin-form-item">
            <label class="allin-form-label" for="subject"><?php echo $lang[124]; ?></label>
            <div class="allin-form-input">
                <div class="allin-form-input-wrap">
                    <input id="msg_subject" name="msg_subject" tabindex="3" class="allin-input-text" type="input" value="Re: <?php echo $row->msg_subject; ?>">
                </div>
            </div>
        </div>
		<div class="allin-form-item allin-form-text add-attach">
				<label class="allin-form-label"><?php echo $lang[498]; ?></label>
				<div class="allin-form-input allin-attach-content util-clearfix">
                                
				<div style="position: relative;" class="allin-attach-item allin-attachment-add util-left allin-attachment-add-en">
				<script src="uploadifive/jquery.uploadifive.js" type="text/javascript"></script>
				<link rel="stylesheet" type="text/css" href="uploadifive/uploadifive.css">
				<script type="text/javascript">
					jQuery(function(){
						jQuery('#file_upload').uploadifive({
							'auto'     : true,
							'formData' : {'id' : '<?php echo $_SESSION['uid']; ?>'},
							'queueID'  : 'queue',
							'debug'    : true,
							'method'   : 'post',
							'uploadScript' : 'ajax-files/upl_temp_msg_file_attach.php',
							'onAddQueueItem' : function(file) {
							//  this.data('uploadifive').settings.formData = {'albums': $('select#albums').val()};
							//$("#pd_pht").html('<img src="images/loader.gif" alt="Uploading...." height="125" width="125"/>');
							},
							'onUploadComplete' : function(file,data) {	
							
								show_temp_attachment(<?php echo $_SESSION['uid']; ?>);
							}
						});
					});
				</script>
				<div id="drop" style="padding-left:10px;">
                	<input type="file" id="file_upload" name="file_upload" multiple="multiple"  class="dpl-btn-gray-smaller"/>
				</div>
                <div id="queue"></div>
		</div>
		<div class="util-left">
                 <link rel="stylesheet" href="css/colorbox.css" />
                 <script src="js/jquery.colorbox.js"></script>
                 <link rel="stylesheet" type="text/css" href="css/a.css">
   <script>
	$(document).ready(function(){
	//Examples of how to assign the ColorBox event to elements
				
		$(".ajax").colorbox({width:"78%"});
		$(".inline").colorbox({inline:true, width:"50%"});
		//Example of preserving a JavaScript event for inline calls.
		$("#click").click(function(){ 
			$('#click').css({"background-color":"#f00", "color":"#fff", "cursor":"inherit"}).text("<?php echo $lang[187]; ?>");
			return false;
		});
	});
		</script>
		<a href="popup_photobank.php" id="select_photo" class="ajax allin-attach-item"><span class="icon icon-attachment-photobank"></span><?php echo $lang[499]; ?></a>
					</div>
				</div>
			</div>
		<div id="attach-container">
						
			
						
					
		</div>
		
				
		<div class="allin-form-item allin-send-content" style="position:relative">
			<div class="allin-form-input-wrap">
				
                <span style="width: 100%; display: block;" class="mceEditor SiteSkin" id="content_parent" aria-labelledby="content_voice" role="application">
                    <span id="content_voice" style="display:none;" class="mceVoiceLabel"><?php echo $lang[503]; ?></span><table style="width: 100%; height: 280px;" class="mceLayout" id="content_tbl" role="presentation" cellpadding="0" cellspacing="0"><tbody><tr class="mceFirst" role="presentation"><td role="presentation" class="mceToolbar mceLeft mceFirst mceLast"><div tabindex="-1" id="content_toolbargroup" role="group" aria-labelledby="content_toolbargroup_voice">
                </div>
                <a href="#" accesskey="z" title="Jump to tool buttons - Alt+Q, Jump to editor - Alt-Z, Jump to element path - Alt-X" onFocus="tinyMCE.getInstanceById('content').focus();"><!-- IE --></a></td></tr><tr><td class="mceIframeContainer mceFirst mceLast"><textarea aria-hidden="true" class="allin-textarea" id="msg_body" name="msg_body" style="height: 320px;width: 750px"></textarea></td></tr><tr class="mceLast"><td class="mceStatusbar mceFirst mceLast"><div aria-labelledby="content_path_voice" role="group" id="content_path_row"><span id="content_path_voice"><?php echo $lang[504]; ?></span><span>: </span><span id="content_path"></span></div></td></tr></tbody></table></span>
			</div>
			<div id="tpl-button" class="tpl-button"></div>
			<div style="display: none;" id="tpl-list" class="allin-list"></div>
		</div>
	</form>
</div>

<div class="allin-toolbar util-clearfix" id="composeBtmBar">
	<div node="107" class="option-list list">
    	<a title="<?php echo $lang[127]; ?>" store="45" data-id="send" node="108" class="allin-toolbar-btn" href="javascript:sendMsg();">
        	<span node="112" class="allin-icon icon-send"></span>
            <span class="allin-text"><?php echo $lang[127]; ?></span>
		</a>
<!--        <a title="Save As Template" store="46" data-id="saveTemplate" node="109" class="allin-toolbar-btn"><span node="113" class="allin-icon icon-set-mail-temp"></span><span class="allin-text">Save As Template</span></a>-->
        <a title="<?php echo $lang[365]; ?>" store="47" data-id="concel" node="110" class="allin-toolbar-btn" onClick="javascript:closeReply()">
        	<span node="114" class="allin-icon icon-cancel"></span>
            <span class="allin-text"><?php echo $lang[365]; ?></span>
		</a>
<!--        <a title="Translation Tool" store="48" data-id="translateTool" node="111" class="allin-toolbar-btn"><span node="115" class="allin-icon icon-translate"></span><span class="allin-text">Translation Tool</span></a>-->
      
      </div></div>