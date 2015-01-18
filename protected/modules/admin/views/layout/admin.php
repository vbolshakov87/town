<?/* @var $this AdminController */?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?=$this->getPageTitle()?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <style>
        body {
            padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
        }
    </style>

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
	<script src="../assets/js/html5shiv.js"></script>
    <![endif]-->
</head>

<body id="admin-body">
<div class="navbar navbar-fixed-top navbar-inverse" role="navigation">
	<div class="container">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="#">История Ярославля</a>
		</div>
		<div class="collapse navbar-collapse">
			<?php
			$this->widget('AdminMenu', array(
				'items'=>array(

					array('label'=>'Дополнительно', 'url'=>array('/admin/topic/admin'), 'items' => array(
						array('label'=>'Темы', 'url'=>array('/admin/topic/admin')),
						array('label'=>'Голосования', 'url'=>array('/admin/poll/admin'), 'visible'=>(Yii::app()->userGroup->isInGroup('admin'))),
						array('label'=>'Настройки', 'url'=>array('/admin/config/admin'), 'visible'=>(Yii::app()->userGroup->isInGroup('admin'))),
						array('label'=>'Страницы', 'url'=>array('/admin/page/admin'), 'visible'=>(Yii::app()->userGroup->isInGroup('admin'))),
						array('label'=>'Блоки', 'url'=>array('/admin/contentBlock/admin'), 'visible'=>(Yii::app()->userGroup->isInGroup('admin'))),
						array('label'=>'Пользователи', 'url'=>array('/admin/user/admin'), 'visible'=>(Yii::app()->getUser()->getUser()->isGroupAdmin())),
						array('label'=>'Группы пользователей', 'url'=>array('/admin/userGroup/admin'), 'visible'=>(Yii::app()->userGroup->isInGroup('admin'))),
					)),
					array('label'=>'Фотохроника', 'url'=>array('/admin/photoStory/admin'), 'items' => array(
						array('label'=>'Фотохроника', 'url'=>array('/admin/photoStory/admin')),
						array('label'=>'Рубрики', 'url'=>array('/admin/photoStoryRubric/admin')),
					)),
					array('label'=>'Исторические материалы', 'url'=>array('/admin/story/admin'), 'items' => array(
						array('label'=>'Исторические материалы', 'url'=>array('/admin/story/admin')),
						array('label'=>'Рубрики', 'url'=>array('/admin/storyRubric/admin')),
					)),
					array('label'=>'Личности', 'url'=>array('/admin/figure/admin'), 'items' => array(
						array('label'=>'Личности', 'url'=>array('/admin/figure/admin')),
						array('label'=>'Рубрики', 'url'=>array('/admin/figureRubric/admin')),
					)),
				),
			));
			?>
			<ul class="nav navbar-nav navbar-right">
				<?if (!empty(Yii::app()->getUser()->getUser()->name) || !empty(Yii::app()->getUser()->getUser()->linkUserGroupUsers[0]->userGroup->name)) :?>
				<li><a href="#"><?=mb_substr(Yii::app()->getUser()->getUser()->name, 0, 16, 'UTF8')?>... (<?=Yii::app()->getUser()->getUser()->linkUserGroupUsers[0]->userGroup->name?>)</a></li>
				<?endif;?>
				<li><a href="<?=Yii::app()->createUrl('/admin/auth/logout')?>">Выйти</a></li>
			</ul>
		</div><!-- /.nav-collapse -->
	</div><!-- /.container -->
</div><!-- /.navbar -->


<div class="container main-container">
	<?
	$this->widget('Breadcrumbs', array(
		'links'=>$this->breadcrumbs,
		'tagName' => 'ol',
		'htmlOptions' => array('class'=>'breadcrumb'),
		'activeLinkTemplate' => '<li><a href="{url}">{label}</a></li>',
		'inactiveLinkTemplate' => '<li class="active">{label}</li>',
		'separator' => ''
	));
	?>
	<?=$content?>
</div> <!-- /container -->

</body>
</html>
