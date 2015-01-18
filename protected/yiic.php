<?php

$path = substr(__FILE__, 0, strpos(__FILE__, DIRECTORY_SEPARATOR . 'protected' ));
$_SERVER['DOCUMENT_ROOT'] = $path . DIRECTORY_SEPARATOR . 'www';
defined('PS_DEBUG') or define('PS_DEBUG',false);
defined('FROM_OFFICE') or define('FROM_OFFICE',false);
date_default_timezone_set('Europe/Moscow');

// боевой сайт
if(strpos(__FILE__, 'Documents') === false ){
	define('_ENVIRONMENT', 'production' );
	$config=dirname(__FILE__).'/config/production.console.php';
	$yiic ='/data/yii/framework/yiic.php';
}

// сайт разработчика
else {
	define('_ENVIRONMENT', 'development' );
	$config=dirname(__FILE__). DIRECTORY_SEPARATOR .'config' .DIRECTORY_SEPARATOR . 'development.console.php';
	$yiic =dirname(__FILE__). DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' .DIRECTORY_SEPARATOR. 'framework' . DIRECTORY_SEPARATOR . 'yiic.php';
}

require_once($yiic);