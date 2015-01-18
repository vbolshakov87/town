<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("О ресурсе");
?>
<link href="/ajax_upload/uploadify.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="/ajax_upload/swfobject.js"></script>
<script type="text/javascript" src="/ajax_upload/jquery.uploadify.v2.1.4.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	$('#file_upload').uploadify({
		'uploader'  : '/ajax_upload/uploadify.swf',
		'script'    : '/ajax_upload/uploadify.php',
		'cancelImg' : '/ajax_upload/cancel.png',
		'folder'    : '/upload/item_upload/',
		'sizeLimit' : 524288,
		'fileExt'        : '*.jpg;*.gif;*.png',
		'fileDesc'       : 'Image Files (.JPG, .GIF, .PNG)',
		'auto'      : true,
		/*'onAllComplete' : function(event,data) {
			console.log(event);
			console.log(data);
			if (fileInfo.length) {
				jQuery.get('/includes/', function(e){
					if (e != 'noimg') {
						if(jQuery("#ava-info").length)  jQuery("#ava-info").attr("src", e);
						else jQuery("#profile .left").prepend('<img id="ava-info" alt="" src="'+e+'">');
					}

				});
			}
		},*/
		'onComplete'  : function(event, ID, fileObj, response, data) {
			console.log(event);
    	}
  });
});
</script>
<input id="file_upload" name="file_upload" type="file" />
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>