<?php
/**
 * @var $this FrontController
 * @var $content
 */
if (empty($this->contentClass))
	$this->contentClass = 'width main cf';
$this->beginContent('/layouts/main');
?>
	<section id="content" class="<?=$this->contentClass;?>">
		<?=$content;?>
	</section>
<?php $this->endContent(); ?>