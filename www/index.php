<?php
// echo md5('admin'); exit;
$defaultLang = 'ru';
$lang = (!empty($_COOKIE['_lang'])) ? $_COOKIE['_lang'] : $defaultLang;
if (!in_array($lang, array('ru', 'en'))) $lang = $defaultLang;
setcookie('_lang', $lang, time() + 60*60*24*180, '/', '.'.$_SERVER['HTTP_HOST']);
define('SITE_LANGUAGE', $lang);


// remove the following line when in production mode
// defined('YII_DEBUG') or define('YII_DEBUG',true);
if (strpos($_SERVER['HTTP_HOST'], '.loc') === false) { // production website
	date_default_timezone_set('Europe/Moscow');
	define('_ENVIRONMENT', 'production');
	define('IS_DEBUG', isset($_GET['yar_debug']));
	if (IS_DEBUG) {
		defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',10);	
		ini_set('html_errors', 1); ini_set("display_errors","1"); ini_set("display_startup_errors","1"); ini_set('error_reporting', E_ALL);defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',10);defined('YII_DEBUG') or define('YII_DEBUG',true);
	}

	$yii='/data/yii/framework/yii.php';
	$config=dirname(__FILE__).'/../protected/config/production.main.php';
}
else { // development
	ini_set('html_errors', 1); ini_set("display_errors","1"); ini_set("display_startup_errors","1"); ini_set('error_reporting', E_ALL);defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',10);defined('YII_DEBUG') or define('YII_DEBUG',true);

    define('_ENVIRONMENT2', 'production');
	define('_ENVIRONMENT', 'development');
	defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',10);
	defined('YII_DEBUG') or define('YII_DEBUG',true);

	$yii=dirname(__FILE__).'/../../framework/yii.php';

	$config=dirname(__FILE__).'/../protected/config/development.main.php';
}



require_once($yii);
Yii::createWebApplication($config)->run();
