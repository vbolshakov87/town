<?/**
 * @var $this FrontController
 */
$q = Yii::app()->getRequest()->getParam('q', '');
?>
<div id="search" class="form" >
	<form action="<?=Yii::app()->createUrl('index/search');?>" method="get">
		<input type="text" name="q" value="<?=$q?>" placeholder="Поиск по статьям и материалам">
		<input type="submit" name="s" value="Y">
	</form>
</div>