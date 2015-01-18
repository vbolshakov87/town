<?/**
 * @var $documents Document[]
 * @var $columns int
 */ ?>
<div id="mainblocks" class="cf">
	<?foreach ($documents as $k => $document) :
		$storyImgSrc = $document->getDocumentImageSrc('top', 'image_top_3', true);
		if (empty($storyImgSrc))
			$storyImgSrc = $document->getDocumentImageSrc('top', 'image', true);
		$storyUrl = $document->createUrl();
	?>
		<article<?if ($k%$columns==($columns-1)) :?> class="last-child"<?endif;?>>
			<a href="<?=$storyUrl;?>"><img src="<?=$storyImgSrc?>" alt="<?=TextModifier::stripText($document->title);?>"></a>
			<div class="cont">
				<h2><a href="<?=$storyUrl;?>"><?=$document->title;?></a></h2>
				<p><?=TextModifier::stripText($document->brief);?></p>
			</div>
		</article>
	<?endforeach;?>
</div>