<?/**
 * @var $item Story
 */ ?>
<div class="pageinfo cf">
	<span class="date"><?=Date::getRussianDate($item->create_time)?></span>
	<?if (!empty($item->hits)) :?> | <span class="cnt"><?=$item->hits?> <?=ChoiceFormat::format(array('просмотр', 'просмотра', 'просмотров'), $item->hits);?></span><?endif;?>
</div>