<?php
class AdminModule extends CWebModule
{

	protected $_isAdmin = true;

	public function init()
	{
		// import the module-level models and components
		$this->setImport(array(
			'admin.models.*',
			'admin.models._base.*',
			'admin.components.*',
			'admin.filters.*',
			'admin.controllers.actions.*',
			'admin.widgets.*',
		));

		$this->layout  = 'admin';
		$this->registerScripts();

		$this->defaultController = 'index';
	}

	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			// this method is called before any module controller action is performed
			// you may place customized code here
			return true;
		}
		else
			return false;
	}


	/**
	 * Registers the necessary scripts.
	 */
	public function registerScripts()
	{
		$cs = Yii::app()->getClientScript();
		$cs->registerCoreScript('jquery');
	//	$cs->registerCoreScript('jquery-ui');

		$basePath= dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets';
		$baseUrl = Yii::app()->getAssetManager()->publish($basePath,false, -1, true);

		// bootstrap
		$cs->registerScriptFile($baseUrl .  '/bootstrap/js/bootstrap.js');
		$cs->registerCssFile($baseUrl . '/bootstrap/css/bootstrap.css');
		// если прошли авторизацию
		if( $this->_isAdmin ) {
			// шрифт
			$cs->registerCssFile($baseUrl . '/fontello/css/fontello.css');


		//	$cs->registerCssFile($baseUrl . '/bootstrap/css/bootstrap-responsive.css');

            // fancybox
            $cs->registerScriptFile($baseUrl . '/fancybox/jquery.fancybox.pack.js');
            $cs->registerCssFile($baseUrl . '/fancybox/jquery.fancybox.css?v=2.1.4');

            // jcrop
            $cs->registerScriptFile($baseUrl . '/jcrop/js/jquery.color.js');
            $cs->registerScriptFile($baseUrl . '/jcrop/js/jquery.Jcrop.min.js');
            $cs->registerCssFile($baseUrl . '/jcrop/css/jquery.Jcrop.min.css');

			$cs->registerScriptFile($baseUrl . '/js/admin.js');
			$cs->registerCssFile($baseUrl . '/css/admin.css');
			$cs->registerCssFile($baseUrl . '/css/poll.css');
		}

	}



}
