<?/**
 * @var $this FrontController
 * @var $content
 */
$cs = Yii::app()->getClientScript();
$cs->registerCoreScript('jquery');
if (_ENVIRONMENT2 === 'production') {
    foreach (Yii::app()->params['clientScriptMini']['js'] as $fileUrl) {
        $cs->registerScriptFile($fileUrl, CClientScript::POS_END);
    }
    foreach (Yii::app()->params['clientScriptMini']['css'] as $fileUrl) {
        $cs->registerCssFile($fileUrl);
    }
} else {
    $cs->registerScriptFile('/js/cookie.js', CClientScript::POS_END);
    $cs->registerScriptFile('/fancybox/jquery.fancybox.pack.js', CClientScript::POS_END);
    $cs->registerScriptFile('/fancybox/helpers/jquery.fancybox-buttons.js', CClientScript::POS_END);
    $cs->registerScriptFile('/fancybox/helpers/jquery.fancybox-thumbs.js', CClientScript::POS_END);
    $cs->registerScriptFile('/fancybox/jquery.fancybox.pack.js', CClientScript::POS_END);
    $cs->registerScriptFile('/js/jquery.customSelect.min.js', CClientScript::POS_END);
    $cs->registerScriptFile('/js/jquery.lazyload.js', CClientScript::POS_END);
    $cs->registerScriptFile('/js/yar/application.js', CClientScript::POS_END);
    $cs->registerScriptFile('/js/jquery.mosaicflow.min.js', CClientScript::POS_END);
    $cs->registerScriptFile('/js/yar/template.js?2015-01-22', CClientScript::POS_END);
    $cs->registerCssFile('http://fonts.googleapis.com/css?family=Oranienbaum|PT+Serif:400,700|Open+Sans:400,600,700&subset=latin,cyrillic');
    $cs->registerCssFile('/css/yar/styles.css?2015-01-22');
    $cs->registerCssFile('/css/yar/template_styles.css?2015-01-22');
    $cs->registerCssFile('/fancybox/jquery.fancybox.css?v=2.1.4');
    $cs->registerCssFile('/fancybox/helpers/jquery.fancybox-buttons.css?v=2.1.4');
    $cs->registerCssFile('/fancybox/helpers/jquery.fancybox-thumbs.css?v=2.1.4');
}

?>
<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title><?=$this->getPageTitle()?></title>
	<!--[if lt IE 9]>
	<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
</head>
<body>
<header id="header">
	<div class="topline">
		<div class="width cf">
			<a class="logo" href="/"><?$this->widget('ContentBlockWidget', array('name' => 'logo'));?></a>
			<h1 class="title"><?$this->widget('ContentBlockWidget', array('name' => 'slogan'));?></h1>
			<div class="righttools">
				<?if (!in_array($this->id, array('story', 'photoStory', 'figure'))) :?>
					<?$this->renderPartial('webroot.themes.yar.views._searchForm');?>
				<?elseif (Yii::app()->getUser()->isGuest === true) :?>
					<a href="<?=Yii::app()->createUrl('admin')?>" target="_blank">Войти в личный кабинет</a>
				<?endif;?>
			</div>
		</div>
	</div>

	<div class="width">
		<div class="secondline cf box">
			<?php $this->widget('NavMenuWidget',array(
				'items'=>array(
					array('label'=>Yii::t('all', 'Photo stories'), 'url'=>array('photoStory/index')),
					array('label'=>Yii::t('all', 'Stories'), 'url'=>array('story/index')),
					array('label'=>Yii::t('all', 'Figures'), 'url'=>array('figure/index')),
					array('label'=>Yii::t('all', 'Places'), 'url'=>'#', 'soon' => true),
				),
			));?>

			<div class="soc">
				<a href="#" class="tw">Twitter</a>
				<a href="#" class="fb">Facebook</a>
				<a href="<?=Yii::app()->createAbsoluteUrl('index/rss')?>" class="rss">RSS</a>
			</div>
		</div>
        <?/*
		<div class="toolsline cf">
			<?if (in_array($this->id, array('story', 'photoStory', 'figure'))) :?>
				<?$this->renderPartial('webroot.themes.yar.views._searchForm');?>
			<?endif;?>
			<?if (in_array($this->id, array('story', 'photoStory', 'figure'))) :?>
				<?$this->widget('CategoryMenuWidget', array('type' => $this->id));?>
			<?endif;?>
		</div>*/?>
	</div>
</header>

<?=$content?>
<footer id="footer">
	<div class="topline width cf">
		<?$this->widget('ContentBlockWidget', array('name' => 'footer_logo'));?>
		<?php $this->widget('NavMenuWidget',array(
			'items'=>array(
				array('label'=>Yii::t('all', 'Photo stories'), 'url'=>array('photoStory/index')),
				array('label'=>Yii::t('all', 'Stories'), 'url'=>array('story/index')),
				array('label'=>Yii::t('all', 'Figures'), 'url'=>array('figure/index')),
				array('label'=>Yii::t('all', 'Places'), 'url'=>'#'),
			),
		));?>
	</div>

	<div class="width info">
		<?$this->widget('ContentBlockWidget', array('name' => 'footer_text'));?>
	</div>
</footer>
<script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-58710352-1', 'auto');
    ga('send', 'pageview');
</script>
</body>
</html>