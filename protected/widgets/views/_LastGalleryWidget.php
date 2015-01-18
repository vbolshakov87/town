<?php
/**
 * @var $data PhotoStory
 */
$url = Yii::app()->createUrl('photoStory/view', array('id'=>$data->id));
$image = $data->getImageSrc('photoStory/sidebar', 'image_sidebar', true);
if (empty($image))
	$image = $data->getImageSrc('photoStory/sidebar', 'image', true);
?>
<div class="history">
	<a href="<?=$url;?>"><img src="<?=$image?>" alt="<?=$data->title;?>"></a>
	<div class="cont">
		<h2><a href="<?=$url?>"><?=$data->title;?></a></h2>
		<?if (!empty($data->brief)):?>
			<p><a href="<?=$url?>"><?=$data->brief?></a></p>
		<?endif;?>
	</div>
</div>