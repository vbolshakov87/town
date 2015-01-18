<?/**
 * @var GalleryPhoto[] $gallery
 */
if (!empty($gallery)) :?>
<h2>Галлерея</h2>

<div class="gal cf">
	<?foreach ($gallery as $photo) :
		$imageSrc = $photo->getImageSrc('gallery/thumb', 'image', true);
		$imageSrcDetail = $photo->getImageSrc('gallery/detail', 'image', true);
	?>
	<a href="<?=$imageSrcDetail?>" class="fancybox-gallery" rel="fancybox-gallery" title="<?=$photo->name?>"><img src="<?=$imageSrc?>" alt="<?=$photo->name?>" class="img"></a>
	<?endforeach;?>
</div>
<?endif;?>