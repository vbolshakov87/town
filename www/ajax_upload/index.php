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
		'auto'      : true
  });
});
</script>
<input id="file_upload" name="file_upload" type="file" />
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>