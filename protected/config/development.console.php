<?php
$developmentConfig = include_once('development.main.php');
$developmentConsoleConfig = $developmentConfig;

//unset($developmentConsoleConfig['basePath']);
unset($developmentConsoleConfig['defaultController']);

$developmentConsoleConfig['modules']['gii'] = false;
$developmentConsoleConfig['components']['log'] = array('enabled' => false);

$developmentConsoleConfig['components']['request'] = array(
	'hostInfo' => 'http://old-yar.loc',
	'baseUrl' => '',
	'scriptUrl' => '',
);

return $developmentConsoleConfig;