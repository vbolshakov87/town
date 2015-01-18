<?php
/**
 * @var $aaa
 * @var $bbb
 * @var $this Controller
 * @var $post Post
 */
$this->pageTitle=Yii::app()->name . ' - About';

$this->breadcrumbs=array(
	'About',
);

Yii::app()->clientScript->registerMetaTag($this->pageTitle, 'og:title');
Yii::app()->clientScript->registerMetaTag($this->pageTitle, 'description');

?>
<h1>About</h1>
<p><?print_r($aaa);?></p>
<p><?=$bbb;?></p>
<p><b>Описание: </b><?=$post->content;?></p>
<p>This is the "about" page for my blog site.</p>