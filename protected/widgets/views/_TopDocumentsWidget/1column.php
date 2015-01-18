<?/**
 * @var $documents Document[]
 */ ?>
<article id="maingal" class="cf">
	<div class="panes">
		<?foreach ($documents as $k => $document) :
			$imageSrc = $document->getDocumentImageSrc('topIndex', 'image_top_1', true);
			if (empty($imageSrc))
				$imageSrc = $document->getDocumentImageSrc('topIndex', 'image', true);
			?>
			<div class="pane<?if ($k == 0) :?> active<?endif;?>">
				<figure>
					<a href="<?=$document->createUrl()?>"><img src="<?=$imageSrc?>" alt="<?=TextModifier::stripText($document->title);?>"></a>
					<figcaption><?=$document->title;?></figcaption>
				</figure>
				<div class="info">
					<h2><a href="<?=$document->createUrl()?>"><?=$document->title;?></a></h2>
					<div><?=TextModifier::stripTextWords(TextModifier::stripText($document->brief), 0, 250, '&hellip;')?></div>
				</div>
			</div>
		<?endforeach;?>
	</div>
	<?if (count($documents) > 1) :?>
		<a class="prev"></a>
		<a class="next"></a>
	<?endif;?>
</article>