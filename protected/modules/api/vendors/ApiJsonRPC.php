<?php

class ApiJsonRPC extends JsonRPC {

	public $debug = false;

	public function __construct() {
		$this->init();
	}

	public function init () {
		parent::__construct();
	}


	public function getRequestMethodName () {
		return $this->_request['method'];
	}

	public function getRequestParams ($paramName = false) {
		if($paramName){
			return $this->_request['params'][0][$paramName];
		}
		else{
			return $this->_request['params'][0];
		}
	}

	public function getInput () {
		if($this->debug && !empty($_REQUEST['request'])){
			return urldecode($_REQUEST['request']);
		}

		return parent::getInput();
	}


	public function isJsonRpcRequest () {
        if($this->debug){
			return true;
		}
		return parent::isJsonRpcRequest();
	}


	public function debug ($debug) {
		$this->debug = $debug;
		/*if ($debug) {
			$this->init();
		}*/
	}

}

class ApiJsonRPCException extends JsonRPCException {}