<?
/**
 * @var GalleryPhoto $image
 */
?>
<li class="rain" id="rain<?=$image->id?>" data-id="<?=$image->id?>">
	<a href="<?=$image->getImageSrc('gallery/detail')?>" class="fancybox"><img src="<?=$image->getImageSrc('gallery/list')?>" alt="<?=$image->name?>" /></a>
	<div class="actions">
		<a  class="btn fancybox btn-success" href="<?=$image->getImageSrc('gallery/detail')?>">Просмотр</a>
		<a href="<?=Yii::app()->createUrl('admin/photoGallery/rename', array('id' => $image->id))?>" class="btn btn-rename btn-info fancybox-ajax">Переименовать</a>
		<a href="javascript:;" class="btn btn-delete btn-danger" onclick="confirm('Вы уверены?') ? $(this).addClass('btn-delete-confirmed') : ''">Удалить</a>
	</div>
	<input type="hidden" value="<?=$image->id?>" name="gallery[items][]" />
</li>
