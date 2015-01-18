<?/**
 * @var GalleryPhoto[] $gallery
 * @var GalleryPhoto $photo
 */
if (!empty($gallery)) :
	$photoCols = array();
	foreach ($gallery as $k => $photo) {
		$photoCols[$k%4][] = $photo;
	}
	?>
	<article class="cf">
		<?foreach ($photoCols as $k => $photoCol) :?>
			<div class="col col<?=($k+1)?>">
				<?foreach ($photoCol as $photo) :
					$imageSrc = $photo->getImageSrc('gallery/thumb', 'image', true);
					$imageSrcDetail = $photo->getImageSrc('gallery/detail', 'image', true);
				?>
					<figure>
						<img src="<?=$imageSrc?>" alt="<?=$photo->name?>">
						<figcaption class="cf">
							<span><?=$photo->name?></span>
							<div>
								<a class="h"></a> | <a class="s fancybox-gallery" href="<?=$imageSrcDetail?>" rel="fancybox-gallery" title="<?=$photo->name?>"></a>
							</div>
						</figcaption>
					</figure>
				<?endforeach;?>
			</div>
		<?endforeach;?>
	</article>
<?endif;?>