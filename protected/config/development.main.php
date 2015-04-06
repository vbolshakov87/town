<?php
// конфиг разработческой версии сайта
$developmentConfig = array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Неизвестные страницы Ярославля',
	'sourceLanguage' => 'en_US',
	'language' => SITE_LANGUAGE,
	'defaultController' => 'index',
	'theme' => 'yar',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.modules.town.components.*',
		'application.modules.town.actions.*',
		'application.modules.town.controllers.*',
		'application.modules.town.models.*',
		'application.modules.town.models._base.*',
		'application.modules.town.vendors.*',
		'application.modules.town.helpers.*',
		'application.modules.town.filters.*',
		'application.modules.town.commands.*',
		'application.models.*',
		'application.models._base.*',
		'application.widgets.*',
		'application.helpers.*',
		'application.actions.*',
		'application.filters.*',
		'application.modules.admin.models.*',
		'application.modules.admin.models._base.*',
		'application.modules.api.vendors.*',
		'application.components.*',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'password',
			'ipFilters'=>array(
				'127.0.0.1',
				'::1',
				'localhost',
			),
		),
		'town',
		'admin',
	),

	// application components
	'components'=>array(
		'user'=>array(
			// enable cookie-based authentication
			'class' => 'WebUser',
			'allowAutoLogin'=> true,
			'stateKeyPrefix' => 'ld_',
		),
		'urlManager'=>array(
			'urlFormat'=>'path',
			'showScriptName'=>false,
			'urlSuffix'=>'',
			'rules'=>array(
				'gii'=>'gii',
				'/' => array('index/index', 'urlSuffix'=>'/'),
				'rss' => array('index/rss', 'urlSuffix'=>'/'),
				/*
				 * роуты по умолчанию (сюда попадает то, что не попало в другие правила)
				 */
				'photo-stories/rubric-<rubricId:\d+>' => array('photoStory/index', 'urlSuffix'=>'/'),
				'photo-stories' => array('photoStory/index', 'urlSuffix'=>'/'),
				'stories/rubric-<rubricId:\d+>' => array('story/index', 'urlSuffix'=>'/'),
				'stories' => array('story/index', 'urlSuffix'=>'/'),
				'figures/rubric-<rubricId:\d+>' => array('figure/index', 'urlSuffix'=>'/'),
				'figures' => array('figure/index', 'urlSuffix'=>'/'),
				'photo-stories/<id:\d+>'=>array('photoStory/view', 'urlSuffix'=>'/'),
				'<controller:\w+>/<id:\d+>'=>array('<controller>/view', 'urlSuffix'=>'/'),
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>array('<controller>/<action>', 'urlSuffix'=>'/'),
				'<controller:\w+>/<action:\w+>'=>array('<controller>/<action>', 'urlSuffix'=>'/'),
			),
		),

		'clientScript' => array
		(
			'scriptMap' => array
			(
				'yii.js' => '/skin-yii/yii.js',
				'jquery.js' => 'http://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js',
				'jquery.min' => 'http://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js',
				'jquery.min.js' => 'http://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js',
                'jquery.cookie.js' => false
			),
		),

		'db' => array (
			'connectionString' => 'mysql:host=localhost;dbname=old_yar',
			'initSQLs' => array('SET NAMES utf8'),
			'emulatePrepare' => true,
			'enableParamLogging' => true,
			'username' => 'root',
			'password' => 'root',
			'charset' => 'utf8',
			'schemaCacheID' => 'cache',
			'schemaCachingDuration' => 60,
			'enableProfiling' => true,
			'tablePrefix' => '',
		),

		// для поиска по сайту
		'sphinxDb' => array(
			'class' => 'system.db.CDbConnection',
			'connectionString' => 'mysql:host=127.0.0.1;port=9306',
			'enableParamLogging' => false,
			'enableProfiling' => false,
		),

		'sphinx' => array(
			'class' => 'SphinxSearch',
			'host' => 'localhost',
			'port' => '9312'
		),


		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				'FileLogRoute' => array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				'WebLogRoute' => array(
					'class' => 'CWebLogRoute',
					'categories' => 'application',
					'showInFireBug' => true,
					'levels'=>'error, warning, trace, profile, info',
				),
				'YiiDebugToolbarRoute' => array(
					'class'=>'ext.yii-debug-toolbar.YiiDebugToolbarRoute',
					'ipFilters'=>array('*'),
				),


				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),

		"cache" => array
		(
/* <- сотри слеш, чтобы включить кеш
			"class" => "system.caching.CDummyCache",
			/*/
			"class" => "system.caching.CFileCache",
//*/
		),
		// lightopenid Применяется в социальной авторизации
		'userGroup' => array(
			'class' => 'UserGroupComponent',
		),

		// почтовые уведомления пользователям
		'mailingEvent' => array(
			'class' => 'MailingEvent',
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		'og_site' => 'www.old-yar.ru',
		'limitOnPage' => 12,
		'alreadyUsedIds' => array(),
		// настройки для отправки писем
		'mail' => array(
			'SMTPSettings' => array(
				'Login' => 'testuser',
				'Password' => 'test',
				'Port' => 25,
				'Host' => 'localhost',
				'SmtpAuth' => false,
			),
			'MailFrom' => array(
				'Email' => 'noreply@photosight.ru',
				'Name' => 'Photo.Sight',
			),
			'salt' => 'e!0tT-81b;\7p_I>y7E№',
		),

		'imageProvider' => 'imagick',

		'poll' => array(
			// Force users to vote before seeing results
			'forceVote' => true,
			// Restrict anonymous votes by IP address,
			// otherwise it's tied only to user_id
			'ipRestrict' => false,
			// Allow guests to cancel their votes
			// if ipRestrict is enabled
			'allowGuestCancel' => true,
		),
	),
);

// конфиг изображений
$developmentConfig['params']['fileParams']['type'] = require(dirname(__FILE__).'/file.params.php');

// minimized files
$minimized = json_decode(file_get_contents(dirname(__FILE__).'/filerevs.json'), true);
foreach ($minimized as $filename => $hash) {
    $filename = str_replace('www/', '/', $filename);
    if (strpos($filename, '.css') !== false) {
        $developmentConfig['params']['clientScriptMini']['css'][] = str_replace('.css', '.'.$hash.'.css', $filename);
    } elseif (strpos($filename, '.js') !== false) {
        $developmentConfig['params']['clientScriptMini']['js'][] = str_replace('.js', '.'.$hash.'.js', $filename);
    }
}
return $developmentConfig;