<?php
/**
 * @var $this FrontController
 * @var $title
 * @var $description
 * @var $keywords
 * @var $image
 * @var $pageUrl
 */
if (!empty($title)) {
	$this->setPageTitle($title);
	Yii::app()->clientScript->registerMetaTag($title, 'og:title');
}
if (!empty($keywords)) {
	Yii::app()->clientScript->registerMetaTag($keywords, 'keywords');
}
if (!empty($description)) {
	Yii::app()->clientScript->registerMetaTag($description);
	Yii::app()->clientScript->registerMetaTag($description, 'og:description');
}
if (!empty($pageUrl)) {
	Yii::app()->clientScript->registerMetaTag($pageUrl, 'og:url');
	if($pageUrl != Yii::app()->getRequest()->hostInfo . Yii::app()->getRequest()->requestUri) {
		Yii::app()->clientScript->registerLinkTag('canonical', null, $pageUrl);
	}
}
if (!empty($image)) {
	Yii::app()->clientScript->registerMetaTag(Yii::app()->getRequest()->hostInfo.$image, 'og:image');
}
Yii::app()->clientScript->registerMetaTag(Yii::app()->params['og_site'], 'og:site_name');
Yii::app()->clientScript->registerMetaTag('website', 'og:type');