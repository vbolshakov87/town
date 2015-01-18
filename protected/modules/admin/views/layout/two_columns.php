<?/* @var $this Controller */ ?>
<?$this->beginContent('application.modules.admin.views.layout.admin'); ?>
<div class="row" style="margin-left: 10px">
	<div class="col-xs-12">
		<div class="row">
			<div class="col-xs-10"><?echo $content; ?></div>
			<div class="col-xs-2">

				<?php
				$this->widget('zii.widgets.CMenu', array(
					'items'=>$this->menu,
					'htmlOptions'=>array('class'=>'nav nav-list bs-docs-sidenav affix'),
				));
				?>
			</div>
		</div>
	</div>
</div>
<?$this->endContent();?>


