<?php
/**
 * @var $this FrontController
 */
$this->beginContent('/layouts/main'); ?>
	<section id="content" class="<?=$this->contentClass?>">
		<div class="col-cont box">
			<?=$content;?>
		</div>

		<aside class="col-right">

			<?$this->renderPartial('webroot.themes.yar.views._pageButtons');?>

			<?/*
			<h2>Объекты в Ярославле связанные с этим событием/личностью</h2>

			<div class="objects block">
				<article class="cf">
					<img src="/images/temp/aside01.jpg" alt="Проспект толбухина">
					<div class="name">Проспект толбухина</div>
				</article>
				<article class="cf">
					<img src="/images/temp/aside01.jpg" alt="Мост имени Толбухина">
					<div class="name">Мост имени Толбухина</div>
				</article>
			</div>
			*/?>
			<?$this->widget('LastGalleryWidget');?>
			<?$this->widget('PollWidget');?>
			<?$this->widget('AllStatWidget');?>
		</aside>

	</section>

<?php $this->endContent(); ?>