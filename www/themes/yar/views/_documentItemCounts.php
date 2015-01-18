<?/**
 * @var $item Document
 */ ?>
<div class="info">
	<span class="date"><?=Date::getRussianDate($item->create_time)?></span><?if (!empty($item->hits)) :?> | <span class="cnt"><?=$item->hits?> <?=ChoiceFormat::format(array('просмотр', 'просмотра', 'просмотров'), $item->hits);?></span><?endif;?> |
	<span class="rate"><i></i><i></i><i></i> 1254 Голосов</span>
</div>