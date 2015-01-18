<?php

class ApiModule extends CWebModule
{
	public $layout = false;


	public function init()
	{
        // import the module-level models and components
        $this->setImport(array(
            'api.controllers.*',
            'api.components.*',
            'api.filters.*',
            'api.vendors.*',
        ));

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

}
