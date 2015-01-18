<?php

class ApiException extends ApiJsonRPCException { }

/**
 * @property ApiJsonRpc $jsonRPC
 */
class ApiBaseController extends Controller
{
	public $layout= false;
	public $jsonRPC;
	public $applicationId;
	protected $_sigSalt;

	public function run($actionID)
	{
		try {
			parent::run($actionID);
		} catch (JsonRPCException $e) {

			$this->jsonRPC->makeErrorResponse($e);
			if($this->jsonRPC->debug){
				print "<pre>";
				var_dump($this->jsonRPC->getResponse());
				print "</pre>";
			}
			else{
				$this->jsonRPC->echoJsonResponse();
			}

			$mailEvent = new MailEvent();
			$mailEvent->actionCanvasPrintServerApiError($this->jsonRPC->getJsonRequest(), $this->jsonRPC->getJsonResponse(), $e);

		} catch (Exception $e) {

			$this->jsonRPC->makeErrorResponse(new JsonRPCException($e->getMEssage()));
			if($this->jsonRPC->debug){
				var_dump($this->jsonRPC->getResponse());
			}
			else{
				$this->jsonRPC->echoJsonResponse();
			}

			$mailEvent = new MailEvent();
			$mailEvent->actionCanvasPrintServerApiError($this->jsonRPC->getJsonRequest(), $this->jsonRPC->getJsonResponse(), $e);
		}

		$apiLog = new ApiLog();
		$apiLog->ctime = time();
		$apiLog->api_type = 'server';
		$apiLog->request = $this->jsonRPC->getJsonRequest();
		$apiLog->application_id = $this->applicationId;
		$apiLog->response = $this->jsonRPC->getJsonResponse();
		$apiLog->save();
	}

	public function init ()
	{
		parent::init();

		$this->jsonRPC = new ApiJsonRPC();
		$this->jsonRPC->debug(Yii::app()->params['api']['debug']);

		if ($this->jsonRPC->debug)
			$this->jsonRPC->setJsonRequest($_GET['data']);

		$this->disableLogs();
	}



	public function filters (){

		$filters = parent::filters();
		$filters[] = array(
					'FilterCheckSig + ApiPingPongSig', //GetUserSID
					'sigSalt'=> $this->_sigSalt,
					'params' => $this->jsonRPC->getRequestParams(),
					'methodName'=>$this->jsonRPC->getRequestMethodName(),
				);

		$filters[] = array(
					'FilterAuthRequired + ApiPingPongAuth',
					'params' => $this->jsonRPC->getRequestParams(),
				);

		return $filters;
	}



	public function actionApiGetVersion ()
	{
		$this->render('/api/index', array('response' => array('version' => $this->version)));
	}

	public function actionApiPingPong ()
	{
		$this->render('/api/index', array('response' => $this->jsonRPC->getRequestParams()));
	}

	public function actionApiPingPongSig ()
	{
		$this->render('/api/index', array('response' => $this->jsonRPC->getRequestParams()));
	}

	public function actionApiPingPongAuth ()
	{
		$this->render('/api/index', array('response' => $this->jsonRPC->getRequestParams()));
	}



}