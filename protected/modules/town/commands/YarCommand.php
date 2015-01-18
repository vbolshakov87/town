<?php
/**
 * Набор консольных команд
 */
class YarCommand extends CConsoleCommand
{
	protected $_actionStartTime;


	protected function beforeAction($action,$params){
		echo "\n\r".date("Y-m-d H:i:s")." Запуск\n\r--------------------------------------------------\n\r";

		$this->_actionStartTime = microtime(true);
		return parent::beforeAction($action,$params);
	}


	protected function afterAction($action,$params){
		echo "\n\r--------------------------------------------------\n\rВремя выполнения: ".(microtime(true)-$this->_actionStartTime) . " секунд\n\r";
		return parent::afterAction($action,$params);
	}


	public function actionIndex (){
		echo <<<EOD

СПИСОК КОММАНД

	- Ping
		Метод для проверки работоспособности консоли


	- FillDocuments
		Метод добавления данных в таблицу документа
		пример:
			./yiic yar FillDocuments

EOD;
	}


	public function getHelp()
	{
		return <<<EOD
ИСПОЛЬЗОВАНИЕ
  protected/yiic PS <action>

EOD;
	}


	/**
	 * Тестовый метод
	 */
	public function actionPing() {
		echo 'pong';
	}


	/**
	 * Метод добавления готовых данных в таблицу документа
	 */
	public function actionFillDocuments()
	{
		echo "\tОчищаем таблицу document\n";
		Document::model()->deleteAll();

		echo "\tЗаписываем story\n";
		$stories = Story::model()->active()->findAll();
		foreach ($stories as $story) {
			$story->save();
		}

		echo "\tЗаписываем photoStory\n";
		$photoStories = PhotoStory::model()->active()->findAll();
		foreach ($photoStories as $photoStory) {
			$photoStory->save();
		}

		echo "\tЗаписываем figure\n";
		$figures = Figure::model()->active()->findAll();
		foreach ($figures as $figure) {
			$figure->save();
		}

		echo "\tГотово\n";
	}
} 