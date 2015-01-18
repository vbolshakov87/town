<?if (!empty($gallery)) :?>
	<div class="clear"></div>
	<h2><?=Yii::t('all', 'Photo galley');?></h2>
	<?$this->widget('FotoramaWidget', array('galleryPhotos' => $gallery));?>
<?endif;?>