<?php
/**
 * @var $response
 */

if($response !== false){
	Yii::app()->getController()->jsonRPC->makeResponse($response);

	if(Yii::app()->getController()->jsonRPC->debug){
		print "<pre style=\"border: 1px solid #000; margin: 10px; padding: 10px;\">";
		var_dump(Yii::app()->getController()->jsonRPC->getResponse());
		print "</pre>";
	}
	else{
		Yii::app()->getController()->jsonRPC->echoJsonResponse();
	}

} else {
	throw new ApiJsonRPCException('The procedure call is not valid', 501);
}
?>