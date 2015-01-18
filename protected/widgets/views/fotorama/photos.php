<?/**
 * @var $this FotoramaWidget
 */
foreach ($data as $photo) {
    Yii::app()->clientScript->registerMetaTag(Yii::app()->getRequest()->hostInfo.$photo['photoSrc'], 'og:image');
    Yii::app()->clientScript->registerMetaTag('image/jpeg', 'og:image:type');
    Yii::app()->clientScript->registerMetaTag($photo['sizeOriginal']['width'], 'og:image:width');
    Yii::app()->clientScript->registerMetaTag($photo['sizeOriginal']['height'], 'og:image:height');
}?>

<div class="fotorama"
     data-nav="thumbs"
     data-width="<?=$this->width?>"
     data-height="<?=$this->height?>"
     data-allowfullscreen="true"
     data-hash="true"
     data-keyboard="true"
     data-transition="dissolve"
     data-thumbheight="64"
     data-swipe="true"
     data-click="true"
     data-loop="true"
	>
	<?foreach ($data as $photo) :?>
		<a href="<?=$photo['photoSrc']?>" id="<?=$photo['id']?>" data-caption="<?=$photo['title']?>"><img src="<?=$photo['photoNavSrc']?>" <?=$photo['size']?> alt="<?=$photo['title']?>" title="<?=$photo['title']?>" data-caption="<?=$photo['title']?>" /></a>
	<?endforeach;?>
</div>