<?require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php"); 
if (!empty($_FILES)) {
	$tempFile = $_FILES['Filedata']['tmp_name'];
	$targetPath = $_SERVER['DOCUMENT_ROOT'] . $_REQUEST['folder'] . '/';
	$fid = CFile::SaveFile($_FILES['Filedata'], "item_file_uploaded");
	$arFile = CFile::GetFileArray($fid);
	echo json_encode(array(
		'id' => $fid,
		'src' => $arFile["SRC"]
	));
}
?>