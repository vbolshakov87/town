<?/**
 * @var $readerCount int
 * @var $authorCount int
 * @var $postCount int
 */ ?>
<div class="stat">
	<div class="hr"></div>

	<p><b><?=$readerCount;?></b> <span class="read"><?=ChoiceFormat::format(array('Читатель', 'Читателя', 'Читателей'), $readerCount);?><span></p>
	<p><b><?=$postCount?></b> <span class="post"><?=ChoiceFormat::format(array('Пост', 'Поста', 'Постов'), $postCount);?></span></p>
	<p><b><?=$authorCount?></b> <span class="post"><?=ChoiceFormat::format(array('Автор', 'Автора', 'Авторов'), $authorCount);?></span></p>

	<div class="hr"></div>
</div>
