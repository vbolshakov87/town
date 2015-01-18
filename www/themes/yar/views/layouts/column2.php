<?php
/**
 * @var $this FrontController
 * @var $content
 */
$this->contentClass = 'width main cf';
$this->beginContent('/layouts/main'); ?>
	<section id="content" class="<?=$this->contentClass;?>">
		<?=$content;?>
		<?$this->renderPartial('webroot.themes.yar.views.layouts._rightColumn');?>
	</section>
<?php $this->endContent(); ?>