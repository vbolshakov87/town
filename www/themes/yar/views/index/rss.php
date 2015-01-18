<?php
/**
 * @var Document[] $items
 * @var FrontController $this
 */
$this->disableLogs();
Yii::import('ext.feed.*');
Yii::import('ext.feed.*');
// RSS 2.0 is the default type
$feed = new EFeed();

$feed->title= 'История города Ярославля';
$feed->description = 'Лента статей в формате RSS 2.0 Feed';

$feed->setImage('Лента статей в формате RSS 2.0 Feed','http://www.old-yar.ru'.Yii::app()->getRequest()->getUrl(), Yii::app()->createAbsoluteUrl('/images/logo.png'));

$feed->addChannelTag('language', 'ru');
$feed->addChannelTag('pubDate', date(DATE_RSS, time()));
$feed->addChannelTag('link',Yii::app()->createAbsoluteUrl(Yii::app()->getRequest()->getUrl()) );

/* @var $news Document */
foreach ($items as $news) {


	$item = $feed->createNewItem();

	$item->title = $news->title;
	$item->link = Yii::app()->createAbsoluteUrl( $news->essence .'/view', array('id' => $news->essence_id)) ;
	$item->date = $news->create_time;
	$item->description = TextModifier::textForMetaTag($news->brief);
	if (!empty($news->image)) {

		$imageSrc = $news->getDocumentImageSrc('detail', 'image', true);
		if (!empty($imageSrc)) {
			$imageSize = getimagesize($_SERVER['DOCUMENT_ROOT'].$imageSrc);
			$imageSrcAbsolute = Yii::app()->createAbsoluteUrl($imageSrc);
			$item->setEncloser($imageSrcAbsolute, filesize($_SERVER['DOCUMENT_ROOT'].$imageSrc), $imageSize['mime']);
		}
	}

	$feed->addItem($item);
}
$feed->generateFeed();
Yii::app()->end();