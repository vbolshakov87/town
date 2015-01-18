<?php
/**
 * Консольные команды
 */
class PSCommand extends CConsoleCommand
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


	- UpdateFotoObraz
		Метод добавления изображений в фотообраз на сайте
		пример:
			./yiic PS UpdateFotoObraz


	- MembersMailing
		Метод рассылки объявления о конкурсе
		параметры:
			--templateName - название шаблона (без UnderWaterStatWidget.php) из папки /views/mailBody/[переменная TemplateName]UnderWaterStatWidget.php
			--firstId - id c которого начинать выбирать пользователей
			--lastId - id которым заканчивать выбирать пользователей
	 		--listIds - список разделенный запятой, с перечислением id пользователей которым будем рассылкать письмо
		пример:
			./yiic PS MembersMailing --templateName=test --firstId=406348 --lastId=406348
			./yiic PS MembersMailing --templateName=test --listIds=405173,406348


	- CreateFilesForSendMailing
		параметры:
			--templateName - название шаблона (без UnderWaterStatWidget.php) из папки /views/mailBody/[переменная TemplateName]UnderWaterStatWidget.php
			--firstId - id пользователя, с которого начинаем рассылку (для рассылки по всем, начинаем с id=1)
			--lastId - id пользователя, которым заканчиваем рассылку (для рассылки по всем, заканчиваем последней id пользователя + 100 штук, чтобы охватить тех, кто зарегался в процессе подготовки рассылки)
			--countStreams - количество потоков (файлов, которые потом запускаются в screen)
			--method - название метода для которого создаем потоки
			--step - шаг вызова команды в одном потоке (сколько id пользователей передавать в метод с названием из --method. Например с 41000 по 42000, если --step=1000)
		пример:
			./yiic PS CreateFilesForSendMailing --templateName=test --firstId=1 --lastId=412337 --countStreams=5 --method=MembersMailing --step=1000


	- FotoObrazMailTest
		Тест отпавки письма пользователю, который попал в фотообраз
		пример:
			./yiic PS FotoObrazMailTest



	- PrivateMailing
		Рассылка личных сообщений (медленный, лучше использовать PrivateMailingBySql)
			--template - шаблон рассылки
			--firstId - id c которого начинать выбирать пользователей
			--lastId - id которым заканчивать выбирать пользователей
			--listIds - список id пользователей, разделенных символом ","
		параметры:
			./yiic PS PrivateMailing  --template=privateMessage --firstId=1 --lastId=2


	- PrivateMailingBySql
		Рассылка личных сообщений использую прямое подключение к sql без использования классов yii
			--template - шаблон рассылки
			--firstId - id c которого начинать выбирать пользователей
			--lastId - id которым заканчивать выбирать пользователей
		параметры:
			./yiic PS PrivateMailingBySql  --template=privateMessage --firstId=1 --lastId=2


	- FotoobrazUserMailing
		Рассылка приглашений на фотообраз месяца участникам фотообраза
		параметры:
			--month - месяц фотообраза
	        --year - год фотообраза
			--dayFrom - начало диапазона дней месяца (по умолчанию 1)
			--dayTo - конец диапазона дней месяца (по умолчанию 31, внутри есть проверка на количество дней в месяце)
	        --template - шаблон рассылки (по умолчанию fotoobrazUser)
		пример:
			./yiic PS FotoobrazUserMailing --month=4 --year=2013 --template=fotoobrazUser
			./yiic PS FotoobrazUserMailing --month=4 --year=2013 --dayFrom=1 --dayTo=15 --template=fotoobrazUser


	- SendEmailTemplateTest
		Тест визуального отображения почтовых шаблонов
		пример:
			./yiic PS SendEmailTemplateTest


	- EmailStat
		Сбор статистики просмотра писем
		пример:
			./yiic PS EmailStat
		
		
	- LjFotoobraz
		Отправка поста "Фотообраз Дня" в ЖЖ
		пример:
			./yiic PS LjFotoobraz

				
	- LjOutrun
		Отправка поста "Фото Дня" в ЖЖ
		параметры:
			--type - тип выбора фотографий по дате (daysBack|secondsBack)
			--daysBack - за какой день выбирать фотографии, от сегодняшнего дня  (0 - сегодня, 1 - за вчера, 2 - за позавчера итд)
	        --secondsBack - за какой период в секундах от текущего времени выбирать фотографии,(3600 - за последний час, 7200 - посление 2 часа итд)
	        --limit - сколько фото выбрать для рассылки
			--limitWithoutCut - сколько фото показывать до ката
		пример:
			./yiic PS LjOutrun --daysBack=1 --limit=2 --limitWithoutCut=1 - показать 2 фото за вчерашний день
			./yiic PS LjOutrun --type=secondsBack --secondsBack=21600 --limit=2 --limitWithoutCut=2 - показать 2 фото за последние 6 часов

	
	- VkNu
		Отправка фото НЮ в группу Вконтакта
		параметры:
			--secondsBack - за какой период в секундах от текущего времени выбирать фотографии
		пример:
			./yiic PS VkNu
			./yiic PS VkNu --secondsBack=21600
		
	
	- NewAnnouncementMailing
		Рассылка письма о новых возможностях объявлений
			--firstId - id c которого начинать выбирать пользователей
			--lastId - id которым заканчивать выбирать пользователей
			--listIds - список id пользователей, разделенных символом ","
		параметры:
			./yiic PS NewAnnouncementMailing  --firstId=1 --lastId=2
			./yiic PS NewAnnouncementMailing  --listIds=406348,402190,405173


	- SetSocialPublicationExpired
		Пометка старых записей со статусом на отправку как просроченных
		параметры:
			--period - время в секундах с текущего момента раньше которого считать записи просроченными
		примеры:
			./yiic PS SetExpired
			./yiic PS SetExpired --period=86400


	- AddToSocialPublicationQueue
		Добавляет в очередь на публикацию в социальные сети
		примеры:
			./yiic PS AddToSocialPublicationQueue

		
	- SocialPublicationToUserPage
		Публикация из очереди в ленту пользователя в социальных сетях
		примеры:
			./yiic PS SocialPublicationToUserPage
		
		
	- SocialPublicationErrorSummary
		Просмотр очереди на постинг в соц. сети на предмет ошибок за последнее время и отправка их списка на почту
		параметры:
			--period - период в секундах с текущего момента за который ищем ошибки
		примеры:
			./yiic PS SocialPublicationErrorSummary
			./yiic PS SocialPublicationErrorSummary --period=86400

	- SyncMemberSettings
		Синхронизация таблицы member_settings с таблицей member
		пример:
			./yiic PS SyncMemberSettings

	- AddTestMemberToSocialPublicationQueue
		Добавление последней фотографии пользователя для постинга в социальные сети
		параметры:
			--memberId - id пользователя
		пример:
			./yiic PS AddTestMemberToSocialPublicationQueue --memberId=406348

	- UpdatePhotoSetsRating
		Обновление рейтинга альбомов
		примеры:
			./yiic PS UpdatePhotoSetsRating

	- MenuMailing
		Рассылка участникам прроекта рестораны Москвы
		параметры:
			--test (по умолчанию - false) - отправлять письма на тестовый email
		пример:
			./yiic PS MenuMailing
			./yiic PS MenuMailing --test=true
		
	- RankPhotosByCurrentRating
		Проставление топ флагов фотографиям
		параметры:
			--limit (по умолчанию 21) - лимит на попадане в топ
			--nu (по умолчанию - false) - режим с ню / без ню
		пример:
			./yiic PS RankPhotosByCurrentRating
			./yiic PS RankPhotosByCurrentRating --nu=true
		
	- MoveOldPhotoRatingsToArchive
		Перенос записей из photo_current_rating в photo_current_rating_archive
		пример:
			./yiic PS MoveOldPhotoRatingsToArchive

	- deleteOldUploadedPhoto
		Удаление записей из таблицы недогруженных фото
		пример:
			./yiic PS deleteOldUploadedPhoto

	- SyncCatalogPhotos
		Добавление в каталог записей из рубрик каталога
		
	- AddToCanvasPrintApiQueue
		Добавление заказов печати на холсте в очередь на отправку партнерам
		
	- SendCanvasPrintApiQueue
		Отправка заказов печати на холсте партнерам
		параметры:
			--limit (по умолчанию 5) - сколько заказов отправляем за один запуск
		пример:
			./yiic PS SendCanvasPrintApiQueue
			./yiic PS SendCanvasPrintApiQueue --limit=7
		
	- ResetTakenCanvasPrintApiQueue
		Сброс статусов taken на new в очереди на отправку заказов печати для тех записей которые не обновлялись определенное кол-во секунд
		параметры:
			--period (по умолчанию - 3600) - время в секундах
		пример:
			./yiic PS ResetTakenCanvasPrintApiQueue
			./yiic PS ResetTakenCanvasPrintApiQueue --period=600

	- SendCanvasPrintMails
		Отправка писем об изменении статуса заказа
		параметры:
			--limit (по умолчанию 100) - сколько писем отправляем за один запуск
		пример:
			./yiic PS SendCanvasPrintMails
			./yiic PS SendCanvasPrintMails --limit=10


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
	 * Тест отправки писем участникам фотообраза
	 */
	public function actionFotoObrazMailTest() {
		// тестовое фото
		$photo = Photo::model()->findByPk(4851675);
		$sendMail = new MailEvent();
		echo $sendMail->actionAddToFotoobrazList($photo);
	}


	/**
	 * Добавление изображений в фотообраз на сайте
	 */
	public function actionUpdateFotoObraz()
	{
		$publicationDone = false;

		$sqlOldData = '
			SELECT t.id
			FROM editor_photo t
			INNER JOIN photo p on p.id = t.photo_id
			WHERE t.approved = 1 AND (p.is_removed = 1 OR p.is_blocked_owner = 1)
		 ';
		// выбираем все устаревшие записи
		$notActivePhotos = Yii::app()->getDb()->createCommand($sqlOldData)->queryAll();
		$photoIds = array();
		foreach ($notActivePhotos as $notActivePhoto) {
			$photoIds[] = $notActivePhoto['id'];
		}
		if (!empty($photoIds)) {
			echo "\tУдаление записей с id ".implode(',', $photoIds) . "\n";
			EditorPhoto::model()->deleteAllByAttributes(array('id'=>$photoIds));
		}
		else {
			echo "\tНет фотографий для удаления\n";
		}

		$rebuildList = false;

		$photoCriteria = new CDbCriteria(array(
			'with' => array(
				'photo' => array(
					'scopes' => array('active'),
					'joinType' => 'inner join'
				),
			),
			'order' => 'photo.ctime ASC',
			'condition' => 't.publication_time <= :time',
			'params' => array(
				':time' => time()
			),
		));
		$editorPhotos = EditorPhoto::model()->findAll($photoCriteria);

		$editorPhotoArr = array();
		$day = 60*60*24;
		foreach ($editorPhotos as $editorPhoto) {

			if ($editorPhoto->photo_day == 1) {
				// находим все фото дня за этит день
				$photoMoreCriteria = new CDbCriteria(array(
					'with' => array(
						'photo' => array(
							'scopes' => array('active'),
							'joinType' => 'inner join'
						),
					),
					'order' => 'photo.ctime ASC',
					'condition' => 'photo.ctime >= :startTime AND photo.ctime <= :finishTime AND t.publication_time > :time',
					'params' => array(
						':time' => time(),
						':startTime' => mktime(0,0,0,date('m',$editorPhoto->photo->ctime), date('d',$editorPhoto->photo->ctime), date('y',$editorPhoto->photo->ctime)),
						':finishTime' => mktime(0,0,0,date('m',$editorPhoto->photo->ctime+$day), date('d',$editorPhoto->photo->ctime+$day), date('y',$editorPhoto->photo->ctime+$day)),
					),
				));
				$editorPhotosMore = EditorPhoto::model()->findAll($photoMoreCriteria);

				if (!empty($editorPhotosMore)) {
					$rebuildList = true;
				}
				foreach ($editorPhotosMore as $editorPhotoMore) {
					$editorPhotoArr[$editorPhotoMore->id] = $editorPhotoMore;
				}
			}

			$editorPhotoArr[$editorPhoto->id] = $editorPhoto;
		}



		foreach ($editorPhotoArr as $editorPhoto) {
			/* @var $editorPhoto EditorPhoto */

			if ($editorPhoto->publicatePhotoOnSite()) {
				// удаляем запись из EditorPhoto
				$photoId = $editorPhoto->photo->id;
				$redisData = unserialize($editorPhoto->photo->getDataForRedis());
				$editorPhoto->delete();

				$publicationDone = true;

				echo "\tПубликация фото $photoId прошла успешно";
				print_R($redisData);
			}
			else {
				echo "\tОшибки в сохранении данных:\n";
				echo "\n<pre>\n";
				print_R($editorPhoto->photo->errors);
				echo "\n</pre>\n";
				Yii::app()->end();
			}
		}


		// перестройка очереди
		if ($rebuildList === true) {
			$criteriaForRepublication = new CDbCriteria(array(
				'with'=>array(
					'photo' => array(
						'select'=>false,
						'scopes'=>array('active'),
					)
				),
				'scopes' => array('approved'),
				'condition' => 't.publication_time > :time',
				'params' => array(
					':time' => time(),
				),
				'order' => 'photo.ctime ASC',
			));
			$editorPhotosForPublication = EditorPhoto::model()->findAll($criteriaForRepublication);
			if (!empty($editorPhotosForPublication)) {
				EditorPhoto::addToPublicationQueue($editorPhotosForPublication, time(), $editorPhotosForPublication[count($editorPhotosForPublication)-1]->publication_time);
			}
		}

		// сброс кеша виджета FotoobrazGalleryWidget
		CacheTaggedHelper::deleteByTags(array('fotoobraz_index'));

		// сброс кеша старого кода для виджета на главной странице
		if (_ENVIRONMENT == 'production' && $publicationDone === true) {
			Yii::app()->limbCache->delete('photosight_review_adult_is_1');
			Yii::app()->limbCache->delete('photosight_review_adult_is_0');
		}

	}


	/**
	 * Рассылка писем
	 * @param int $templateName - название шаблона (без UnderWaterStatWidget.php) из папки /views/mailBody/{$templateName}UnderWaterStatWidget.php
	 * @param int $firstId - id c которого начинаем рассылку
	 * @param int $lastId - id которым заканчиваем рассылку
	 * @param string $listIds - список id разделенных запятой
	 * @throws Exception
	 */
	public function actionMembersMailing($templateName, $firstId=1, $lastId=1, $listIds = '')
	{
		/* директория MembersMailing: в методе actionCreateFilesForSendMailing создаётся директория с названием метода, который будет запускаться для непосредственно выполнения отправки писем.
		 В данном случае - это метод actionMembersMailing, т.е. будет создана директория MembersMailing */
		$errorFileDir = dirname(__FILE__). DIRECTORY_SEPARATOR .'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'bash'.DIRECTORY_SEPARATOR.'MembersMailing';
		//if (!file_exists($errorFileDir)) mkdir($errorFileDir, 0775, true); создаётся в actionCreateFilesForSendMailing
		try {
			if (!empty($listIds)) {
				$users = Yii::app()->db->createCommand()->select('t.id, t.email, t.name, t.hashed_password')->from('member t')->where('
					t.mailing_events_receipt_type = 10
					AND t.is_mail_photosight_message = 1
					AND t.is_activated = 1
					AND t.is_removed = 0
					AND t.id IN ('.$listIds.')
				')->queryAll();
			}
			else {
					$users = Yii::app()->db->createCommand()->select('t.id, t.email, t.name, t.hashed_password')->from('member t')->where('
						t.mailing_events_receipt_type = 10
						AND t.is_mail_photosight_message = 1
						AND t.is_activated = 1
						AND t.is_removed = 0
						AND t.id BETWEEN :firstId AND :lastId
					', array(':firstId'=>$firstId, 'lastId'=>$lastId))->queryAll();
			}


			$content = $this->renderFile(Yii::app()->basePath . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'mailBody' . DIRECTORY_SEPARATOR . $templateName.'UnderWaterStatWidget.php', null, true);

			$mail = new PSPhpMailer();
			$mail->mailConnect();

			foreach ($users as $k=>$user) {

				$mail->Subject = 'Георгий Пинхасов выбирает лучших на «Фото.Сайте»';
				$userId = $user['id'];

				$mail->ClearAddresses(); // сбрасываем все прошлые адреса

				$code = md5($user['id'].$user['hashed_password'].Yii::app()->params['mail']['salt']);
				$mail->Body = str_replace(array('#USER_ID#', '#USER_CODE#', '#USER_EMAIL#'), array($user['id'], $code, $user['email']), $content);
				$mail->AddAddress($user['email'], $user['name']);

				if($mail->Send()) {
					echo "\tOK - $userId\n\r";
				}
				else {
					echo "\tERR - $userId\\n\r";
					throw new Exception('Ошибка отправки письма');
				}
			}
		}
		catch (Exception $e) {
			if (empty($user)) $user = array();
			file_put_contents($errorFileDir . DIRECTORY_SEPARATOR . 'error.txt', print_r( array('user'=>$user, 'getMessage'=>$e->getMessage(), 'getCode'=>$e->getCode(), 'getFile'=>$e->getFile(), 'getLine'=>$e->getLine()),true), FILE_APPEND);
		}

	}


	/**
	 * Создание файлов для выполнения потоковых команд
	 * @param $templateName - название шаблона (без UnderWaterStatWidget.php) из папки /views/mailBody/[переменная TemplateName]UnderWaterStatWidget.php
	 * @param $firstId - id пользователя, с которого начинаем рассылку (для рассылки по всем, начинаем с id=1)
	 * @param $lastId - id пользователя, которым заканчиваем рассылку (для рассылки по всем, заканчиваем последней id пользователя + 100 штук, чтобы охватить тех, кто зарегался в процессе подготовки рассылки)
	 * @param $countStreams - количество потоков
	 * @param $method - название команды для запуска
	 * @param int $step - количество пользователей в одном шаге
	 */
	public function actionCreateFilesForSendMailing($templateName, $firstId, $lastId, $countStreams, $method, $step = 1000)
	{
		if ( ($lastId - $firstId)  < 0) return;

		$projectDir = realpath($_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . '..' .DIRECTORY_SEPARATOR);
		$protectedDirPath = $projectDir . '/protected/';
		$scriptDirPath = $projectDir . '/bash/';
		$directory = $scriptDirPath . $method;

		if (!is_dir($directory))
			mkdir($directory, 0775, true);

		$inFile = floor(($lastId - $firstId + 1)/$countStreams);

		for ($i = 1; $i <= $countStreams; $i++) {
			$text = "#!/bin/bash\ncd ".$protectedDirPath."\n\n\n";

			$listFirst = $firstId + $inFile * ($i-1);
			$listLast = $firstId + $inFile * $i - 1;

			if ($i == $countStreams)
				$currentLast = $lastId;

			$k = 0;
			$currentLast = $listFirst;
			while($currentLast < $listLast) {
				$currentFirst = $listFirst + $step*$k;
				$currentLast = $currentFirst + $step - 1;
				if ($currentLast > $listLast)
					$currentLast = $listLast;

				$text .= "./yiic PS $method --templateName=$templateName --firstId=$currentFirst --lastId=$currentLast >> $directory/log_stream".$i."__firstId_".$currentFirst."__lastId_".$currentLast.".txt\n";

				$k++;
			}

			file_put_contents($directory . DIRECTORY_SEPARATOR . 'stream'.$i,  $text);

			echo $listFirst . '---' . $listLast . "\t";
			echo " в файле " . $directory . DIRECTORY_SEPARATOR . 'stream'.$i."\n";

		}
	}



	/**
	 * Рассылка личных сообщений
	 * @param string $template - название шаблона рассылки. Используется файл  /views/privateMessageBody/$template.txt
	 * @param int $firstId - id c которого начинаем рассылку
	 * @param int $lastId - id которым заканчиваем рассылку
	 * @throws Exception
	 */
	public function actionPrivateMailing($template='privateMessage', $firstId=406348, $lastId=406348)
	{
		$errorFileDir = dirname(__FILE__). DIRECTORY_SEPARATOR .'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'bash'.DIRECTORY_SEPARATOR.'privateMessage';
		if (!is_dir($errorFileDir))
			mkdir($errorFileDir, 0775, true);

		try {

			$useStepSize = 200;
			$steps = floor(($lastId - $firstId + 1)/$useStepSize);
			if ($steps == 0 && $lastId>=$firstId) $steps = 1;

			//$content = $this->renderFile(Yii::app()->basePath . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'privateMessageBody' . DIRECTORY_SEPARATOR . $template .'UnderWaterStatWidget.php', null, true);
			$content = file_get_contents(Yii::app()->basePath . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'privateMessageBody' . DIRECTORY_SEPARATOR . $template .'.txt');
			$content = '"'.str_replace(array('\\', "\0", "\n", "\r", "'", '"', "\x1a"), array('\\\\', '\\0', '\\n', '\\r', "\\'", '\\"', '\\Z'), $content).'"';
			$sender_id = PrivateMessage::FROM_PS_USER_ID;


			for ($i = 1; $i <= $steps; $i++) {

				$currentFirstId = $firstId + $useStepSize * ($i-1);
				$currentLastId = $firstId + $useStepSize * $i - 1;

				if ($i == $steps)
					$currentLastId = $lastId;

				echo "\n$currentFirstId - $currentLastId\n\r";


				$users = Yii::app()->db->createCommand()->select('t.id')->from('member t')->where('
						t.is_activated = 1
						AND t.is_removed = 0
						AND t.id BETWEEN :firstId AND :lastId
					', array(':firstId'=>$currentFirstId, 'lastId'=>$currentLastId))->queryAll();

				if (empty($users))
					continue;

				$sql = 'INSERT INTO private_message (sender_id, recipient_id, ctime, utime, content, conversation_uid, removed_for) VALUES ';

				$usersCount = count($users);
				$comma = ',';
				$userI=1;
				foreach ($users as $user) {

					$attributes = array(
						'sender_id' => $sender_id,
						'recipient_id' => $user['id'],
						'ctime' => time(),
						'utime' => time(),
						'content' => $content,
						'conversation_uid' =>  '"'.md5((string)min($sender_id, $user['id']) . (string)max($sender_id, $user['id'])).'"',
						'removed_for' => $sender_id,
					);

					if($userI++ >= $usersCount) $comma = '';

					$sql .= "(". implode(',', $attributes) .")".$comma;
				}
				//$sql = rtrim($sql, ',');
				//$sql .= implode(",\n", $sqlData);
				//unset($sqlData);
				Yii::app()->db->createCommand($sql)->execute();
				unset($sql);
				echo "OK - $currentFirstId - $currentLastId";
			}

		}
		catch (Exception $e) {
			if (empty($currentFirstId)) $currentFirstId = 0;
			if (empty($currentLastId)) $currentLastId = 0;
			echo "\tERR - $currentFirstId - $currentLastId";
			file_put_contents($errorFileDir . DIRECTORY_SEPARATOR . 'error.txt', print_r( array('getMessage'=>$e->getMessage(), 'getCode'=>$e->getCode(), 'getFile'=>$e->getFile(), 'getLine'=>$e->getLine()),true), FILE_APPEND);
			throw $e;

		}

	}


	/**
	 * Оптимизированная рассылка личных сообщений
	 * @param string $template - шаблон рассылки
	 * @param int $firstId - id c которого начинаем рассылку
	 * @param int $lastId - id которым заканчиваем рассылку
	 * @throws Exception
	 */
	public function actionPrivateMailingBySql($template='privateMessage', $firstId=406348, $lastId=406348)
	{
		$errorFileDir = dirname(__FILE__). DIRECTORY_SEPARATOR .'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'bash'.DIRECTORY_SEPARATOR.'PrivateMailing';
		if (!is_dir($errorFileDir))
			mkdir($errorFileDir, 0775, true);

		try {

			$useStepSize = 200; // сколько insert команд выполняется в одном insert запросе
			$steps = floor(($lastId - $firstId + 1)/$useStepSize);
			if ($steps == 0 && $lastId>=$firstId) $steps = 1;

			$content = file_get_contents(Yii::app()->basePath . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'mailBody' . DIRECTORY_SEPARATOR . $template .'UnderWaterStatWidget.php');
			$content = '"'.str_replace(array('\\', "\0", "\n", "\r", "'", '"', "\x1a"), array('\\\\', '\\0', '\\n', '\\r', "\\'", '\\"', '\\Z'), $content).'"';
			$sender_id = PrivateMessage::FROM_PS_USER_ID;

			$configFileName = _ENVIRONMENT == 'production' ? 'production.main.php' : 'development.main.php';
			$config = require(dirname(__FILE__).'/../config/'.$configFileName);

			$mysqlConnectArr = explode(';', $config['components']['db']['connectionString']);
			$mysqlUsername = $config['components']['db']['username'];
			$mysqlPassword = $config['components']['db']['password'];
			$host = str_replace('mysql:host=', '', $mysqlConnectArr[0]);
			$port = str_replace('port=', '', $mysqlConnectArr[1]);
			$dbname = str_replace('dbname=', '', $mysqlConnectArr[2]);


			mysql_connect($host, $mysqlUsername, $mysqlPassword);
			mysql_select_db($dbname);
			mysql_query('SET NAMES utf8');
			for ($i = 1; $i <= $steps; $i++) {

				$currentFirstId = $firstId + $useStepSize * ($i-1);
				$currentLastId = $firstId + $useStepSize * $i - 1;

				if ($i == $steps)
					$currentLastId = $lastId;

				echo "\n$currentFirstId - $currentLastId\n\r";

				$users = mysql_query("SELECT t.id from member t where t.is_activated = 1
										AND t.is_removed = 0
										AND t.id BETWEEN {$currentFirstId} AND {$currentLastId}");

				if (mysql_num_rows($users)==0)
					continue;

				$sql = 'INSERT INTO private_message (sender_id, recipient_id, ctime, utime, content, conversation_uid, removed_for) VALUES ';

				$usersCount = mysql_num_rows($users);
				$comma = ',';
				$userI=1;
				while ($user = mysql_fetch_array($users)) {

					$attributes = array(
						'sender_id' => $sender_id,
						'recipient_id' => $user['id'],
						'ctime' => time(),
						'utime' => time(),
						'content' => $content,
						'conversation_uid' =>  '"'.md5((string)min($sender_id, $user['id']) . (string)max($sender_id, $user['id'])).'"',
						'removed_for' => $sender_id,
					);

					if($userI++ >= $usersCount) $comma = '';

					$sql .= "(". implode(',', $attributes) .")".$comma;
				}
				mysql_query($sql);
				unset($sql);

				echo "\tOK - $currentFirstId - $currentLastId";
			}

		}
		catch (Exception $e) {
			if (empty($currentFirstId)) $currentFirstId = 0;
			if (empty($currentLastId)) $currentLastId = 0;
			echo "\tERR - $currentFirstId - $currentLastId";
			file_put_contents($errorFileDir . DIRECTORY_SEPARATOR . 'error.txt', print_r( array('getMessage'=>$e->getMessage(), 'getCode'=>$e->getCode(), 'getFile'=>$e->getFile(), 'getLine'=>$e->getLine()),true), FILE_APPEND);
			throw $e;
		}
	}



	/**
	 * Рассылка приглашений на фотообраз месяца
	 * @param $month - месяц фотообраза
	 * @param $year - год фотообраза
	 * @param $dayFrom - день месяца, начало диапазона дней
	 * @param $dayFrom - день месяца, конец диапазона дней
	 * @param string $template - шаблон рассылки
	 * @throws Exception
	 */
	public function actionFotoobrazUserMailing($month, $year, $dayFrom=1, $dayTo=31, $template='fotoobrazUser')
	{
		$errorFileDir = dirname(__FILE__). DIRECTORY_SEPARATOR .'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'bash'.DIRECTORY_SEPARATOR.'FotoobrazUserMailing';
		if (!is_dir($errorFileDir))
			mkdir($errorFileDir, 0775, true);

		try {
			$criteria = new CDbCriteria(array(
				'with' => array(
					'photo' => array(
						'select' => false,
						'joinType' => 'inner join',
						'scopes' => array('editorsChoice'),
					)
				),
				'condition' => 'photo.ctime >= :start_date AND photo.ctime <= :finishDate',
				'params' => array(
					':start_date' => mktime(0,0,0,$month, $dayFrom, $year),
					':finishDate' => mktime(23,59,59,$month, ($dayTo > Date::cal_days_in_month($month, $year) ? Date::cal_days_in_month($month, $year) : $dayTo), $year),
				)
			));

			$criteria = new CDbCriteria(array(
				'condition' => 't.id IN (406348, 414184, 405173)'
			));

			$members = Member::model()->findAll($criteria);

			if (!empty($members)) {
				$mailer = new PSPhpMailer();
				$mailer->mailConnect();

				//$memberIdArr = array();

				foreach ($members as $member) {
					/** @var $member Member */
					//$memberIdArr[] = $member->id;

					$mailer->ClearAddresses(); // сбрасываем все прошлые адреса
					$mailer->AddAddress($member->email, $member->name);
					$mailer->Body = $this->renderFile(Yii::app()->basePath . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'mailBody' . DIRECTORY_SEPARATOR . $template .'UnderWaterStatWidget.php', array('member'=>$member, 'mailer'=>$mailer), true);;

					if($mailer->Send()) {
						echo "\tOK - {$member->id}";
					}
					else {
						echo "\tERR - {$member->id}";
						throw new Exception('Ошибка отправки письма');
					}

				}

				//$memberIds = implode(', ', $memberIdArr);
				//echo "\tresult: $memberIds\\n\r";
			}
		}
		catch (Exception $e) {
			echo "\tERR";
			file_put_contents($errorFileDir . DIRECTORY_SEPARATOR . 'error.txt', print_r( array('getMessage'=>$e->getMessage(), 'getCode'=>$e->getCode(), 'getFile'=>$e->getFile(), 'getLine'=>$e->getLine()),true), FILE_APPEND);
			throw $e;

		}

	}


	/**
	 * Тест почтовых шаблонов
	 */
	public function actionSendEmailTemplateTest()
	{
		$mailer = new PSPhpMailer();
		$mailer->mailConnect();
		$mailer->Subject = 'Красивое письмо';
		$mailer->AddAddress('vbolshakov87@gmail.com', 'Vbolshakov');
		$member = Member::model()->findByPk(406348);
		$photo  = Photo::model()->findByPk(5088384);
		$mailer->Body = $this->renderFile(Yii::app()->basePath . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'mailBody' . DIRECTORY_SEPARATOR . 'socialPublicationEmail.php', array('member'=>$member, 'photo'=>$photo), true);
		$mailer->Send();
		echo "OK";
	}


	/**
	 * Сбор статистики просмотра писем
	 */
	public function actionEmailStat()
	{
		$statFileDir = dirname(__FILE__). DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR .'data' . DIRECTORY_SEPARATOR . 'mailpixel';
		if (!is_dir($statFileDir))
			mkdir($statFileDir, 0775, true);

		$types = array('photoForum', 'FotoobrazApril', 'FotoobrazUser_04_2003', 'aboutEvents_04_2013', 'profile_large_preview_05_2013', 'FotoobrazMay', 'FotoobrazUser_05_2013', 'socialMailing1', 'socialMailing2', 'FotoobrazJune', 'FotoobrazUser_06_2013', 'albums', 'restoran_16_08_2013__1', 'restoran_16_08_2013__2', 'restoran_16_08_2013__3', 'restoran_3','contest_nikon', 'search_page', 'FotoobrazAugust_2013', 'FotoobrazPinhasov_2013');

		foreach ($types as $type) {
			echo "\n\t\t$type\n\r";
			$content = file_get_contents('http://www.photosight.ru/mailpixel/'.$type.'/pixel');
			$data = date('d.m.Y H:i:s') .' - '.trim($content) . "\n";
			file_put_contents($statFileDir . DIRECTORY_SEPARATOR . $type .'.txt', $data, FILE_APPEND);
		}
	}
	
	
	/**
	 * Автоматический постинг фотообраза дня в Livejournal
	 */
	public function actionLjFotoobraz()
	{
		//определяем дату за которую будем рассылать
		$sql = "SELECT DATE_FORMAT(fotoobraz_date, '%Y-%m-%d')
				FROM lj_fotoobraz_posting_log
				WHERE fotoobraz_date > DATE_SUB(NOW(), INTERVAL 8 DAY)";
		$days = Yii::app()->getDb()->createCommand($sql)->queryColumn();
		for($i = 7; $i > 1; $i--)
		{
			if(!in_array(date('Y-m-d', mktime(0, 0, 0, date('m'), date('j') - $i, date('Y'))), $days))
			{
				$dayStart = mktime(0, 0, 0, date('m'), date('j') - $i, date('Y'));
				$dayEnd = mktime(23, 59, 59, date('m'), date('j') - $i, date('Y'));
				break;
			}
		}

		if(isset($dayStart)) {
			//проверяем есть ли утвержденные но еще не опубликованные фото за этот день
			$criteria_check = new CDbCriteria(array(
				'with' => array('photo'),
				'together' => true,
				'scopes' => array('approved'),
				'condition' => 'photo.ctime BETWEEN :day_start AND :day_end',
				'params' => array(
					':day_start' => $dayStart,
					':day_end' => $dayEnd,
				),
			));
			//если есть, то пока не публикуем и прекращаем выполнение скрипта
			if(EditorPhoto::model()->exists($criteria_check))
			{
				echo "\tЕще не все утвержденные фотографии опубликованы";
				return;
			}
			
			//ищем Фото дня и номинантов
			$criteria = new CDbCriteria(array(
				'with' => array('member'),
				'together' => true,
				'scopes' => array('active'),
				'condition' => '(t.ctime BETWEEN :day_start AND :day_end) AND (t.is_editors_choice_photoday=1 OR t.is_editors_choice = 1)',
				'params' => array(
					':day_start' => $dayStart,
					':day_end' => $dayEnd,
				),
				'order' => 't.is_editors_choice_photoday DESC, t.ctime DESC',
			));
			$photos = Photo::model()->findAll($criteria);

			//если фото дня определено (оно должно быть первым элементом массива), то делаем пост в ЖЖ
			if(!empty($photos) && $photos[0]['is_editors_choice_photoday']==1) {
				Yii::import('ext.livejournal.*');
				$post = new ELivejournal(Yii::app()->params['livejournal']['login'], Yii::app()->params['livejournal']['password'], true);

				if(Yii::app()->params['livejournal']['journal']!='')
				{
					$post->setUsejournal(Yii::app()->params['livejournal']['journal']);
				}
				
				//собираем пост
				$post->subject = 'Номинанты на участие в выставке «Фото.Образ» за ' . Date::getRussianDate($dayStart);

				$post->body = $this->renderFile(
									Yii::app()->basePath . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'livejournal' . DIRECTORY_SEPARATOR . 'fotoobraz.php',
									array(
										'photos' => $photos,
										'dayStart' => $dayStart,
									),
									true);

				$post->time = time();
				$post->tags = array('Фото.Образ', 'Фото.Образ.'.  Yii::app()->locale->getMonthName(date('n', $dayStart), 'wide', true), 'выставка');
				
				//чтобы ЖЖ не транслировал символы новой строки в <br> 
				$post->setDeleteNewLines();

				if ($post->save())
				{
					echo "\n\t\tОпубликовано: " . $post->url . "\n";
					$sql = "INSERT INTO lj_fotoobraz_posting_log(fotoobraz_date, ctime, post_url)
							VALUES(:fotoobraz_date, :time, :post_url)";
					$command = Yii::app()->getDb()->createCommand($sql);
					$command->bindParam(":fotoobraz_date", date('Y-m-d', $dayStart));
					$command->bindParam(":time", time());
					$command->bindParam(":post_url", $post->getUrl());
					$command->execute();
				}
				else
				{
					echo "\tОшибка #" . $post->errorCode . ": " . $post->error;
				}
			}
			else {
				echo "\tНет фотографий для публикации";
			}
		}
		else {
			echo "\tУже все опубликовано";
		}
	}

	
	/**
	 * Автоматический постинг фото дня в Livejournal
	 * @param string $type - тип выбора фотографий по дате (daysBack|secondsBack)
	 * @param int $daysBack - за какой период в секундах от текущего времени выбирать фотографии,(3600 - за последний час, 7200 - посление 2 часа итд)
	 * @param int $secondsBack - за какой день выбирать фотографии, от сегодняшнего дня  (0 - сегодня, 1 - за вчера, 2 - за позавчера итд)
	 * @param int $limit - сколько фото выбрать для рассылки
	 * @param int $limitWithoutCut - сколько фото показывать до ката
	 */
	public function actionLjOutrun($type = 'daysBack', $daysBack = 1, $secondsBack = 0, $limit = 2, $limitWithoutCut = 2)
	{
		if($type == 'secondsBack')
		{
			$timeFrom = time() - $secondsBack;
			$timeTo = time();
		}
		else
		{
			$timeFrom = mktime(0, 0, 0, date('m'), date('j') - $daysBack, date('Y'));
			$timeTo = mktime(23, 59, 59, date('m'), date('j') - $daysBack, date('Y'));
		}
		
		$criteria = new CDbCriteria(array(
			'with' => array('member'),
			'together' => true,
			'scopes' => array('isTop', 'withoutNu', 'active'),
			'condition' => 't.ctime BETWEEN :timeFrom AND :timeTo',
			'params' => array(
				':timeFrom' => $timeFrom,
				':timeTo' => $timeTo,
			),
			'order' => 'RAND()',
			'limit' => $limit,
		));
		
		$photos = Photo::model()->findAll($criteria);

		if(!empty($photos)) {
			Yii::import('ext.livejournal.*');
			$post = new ELivejournal(Yii::app()->params['livejournal']['login'], Yii::app()->params['livejournal']['password'], true);
			if(Yii::app()->params['livejournal']['journal']!='')
			{
				$post->setUsejournal(Yii::app()->params['livejournal']['journal']);
			}
			
			$post->subject = 'Фото дня';
			$post->body = $this->renderFile(
								Yii::app()->basePath . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'livejournal' . DIRECTORY_SEPARATOR . 'outrun.php',
								array(
									'photos' => $photos,
									'limitWithoutCut' => $limitWithoutCut,
									'timeFrom' => $timeFrom,
								),
								true);
			$post->time = time();
			$post->tags = array('Фото дня', 'фото');
			$post->setDeleteNewLines(); //чтобы ЖЖ не транслировал символы новой строки в <br>

			if ($post->save())
			{
				echo "\tОпубликовано: " . $post->url;
			}
			else
			{
				echo "\tОшибка #" . $post->errorCode . ": " . $post->error;
			}
		}
		else {
			echo "\tНет фотографий для публикации";
		}
	}
	
	
	/**
	 * Автоматический постинг фото НЮ в сообщество Вконтакте
	 * @param int $secondsBack - за какой период в секундах от текущего времени выбирать фотографии
	 */
	public function actionVkNu($secondsBack = 21600)
	{
		//если в логе ошибок есть запись о необходимости ввести капчу, то прекращаем работу скрипта
		if(VkPhotoPostingErrorLogModel::checkCaptchaError())
		{
			echo "\tERROR: Есть нерешенная капча\n";
			return;
		}
		
		//параметры постинга
		$params = Yii::app()->params['vk_posting'];
		$group_id = $params['nu_group'];
		
		//определяем id фотографий которые уже были опубликованы
		$sql = "SELECT object_id
				FROM vk_photo_posting_log
				WHERE object_type='photo' AND profile_id=:profile_id";
		$command = Yii::app()->getDb()->createCommand($sql);
		$command->bindParam(":profile_id", $group_id);
		$already_published = $command->queryColumn();
		
		//выбираем фотографию для постинга
		$criteria = new CDbCriteria(array(
			'with' => array(
				'photo'=>array(
					'scopes' => array('active'),
				),
			),
			'scopes' => array('VkNu'),
			'condition' => 't.photo_ctime>:time',
			'params' => array(
				':time' => time() - $secondsBack,
			),
			'together' => true,
			'order' => 'RAND()',
			'limit' => 1,
		));
		if(count($already_published)>0) $criteria->addNotInCondition('t.id', $already_published);
		$photo = PhotoCurrentRating::model()->find($criteria);

		if(empty($photo->photo))
		{
			echo "\tНет фотографий для публикации";
			return;
		}
		
		//скачиваем фотографию во временную папку для загрузки Вконтакт
		$photoOfDayFile = $photo->photo->getImageSrc('photo/large');
		$tmpfile = sys_get_temp_dir() .DIRECTORY_SEPARATOR. 'vkpost' . $photo->id.'.jpg';

		if(!@copy($photoOfDayFile, $tmpfile) || filesize($tmpfile)==0)
		{
			$errlog = new VkPhotoPostingErrorLogModel();
			$errlog->object_id = $photo->id;
			$errlog->object_type = 'photo';
			$errlog->profile_id = $group_id;
			$errlog->ctime = time();
			$errlog->error_msg = 'Не удалось скачать файл фото' . $photoOfDayFile;
			$errlog->save();
			echo "\tНе удалось скачать файл фото" . $photoOfDayFile;
			return;
		}

		try
		{
			$vk2 = new PSVkapi($params['app_id'], $params['api_secret'], $params['token']);

			// Загрузка фото
			$response = $vk2->api('photos.getWallUploadServer', array(
				'gid' => abs($group_id),
			));
			
			//закачиваем фото во Вконтакт и удаляем временный файл
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_URL, $response['response']['upload_url']);
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, array(
				'photo' => '@' . $tmpfile . ';type=image/jpeg',
			));
			$response = json_decode(curl_exec($ch));
			unlink($tmpfile);

			// Сохраняем фото
			$response = $vk2->api('photos.saveWallPhoto', array(
				'server' => $response->server,
				'photo' => $response->photo,
				'hash' => $response->hash,
				'gid' => abs($group_id),
			));

			// Пишем пост с прикреплённой фотографией, которую загрузили выше
			$response = $vk2->api('wall.post', array(
				'owner_id' => $group_id,
				'message' => "#photosight_nu #photo #ню,  @club40592710 (Смотреть больше НЮ) \nПосмотреть поближе: " . Yii::app()->createAbsoluteUrl('photo/view', array('id'=>$photo->photo->id)),
				'attachments' => $response['response'][0]['id'],
				'from_group' => 1,
			));
			
			//пишем в лог
			$log=new VkPhotoPostingLogModel;
			$log->object_id = $photo->id;
			$log->object_type = 'photo';
			$log->profile_id = $group_id;
			$log->ctime = time();
			$log->vkpost_id = $response['response']['post_id'];
			$log->save();
			echo "\tОпубликовано ".$response['response']['post_id'];
		}
		catch(VKException $vkErr)
		{
			$errlog = new VkPhotoPostingErrorLogModel();
			$errlog->object_id = $photo->id;
			$errlog->object_type = 'photo';
			$errlog->profile_id = $group_id;
			$errlog->ctime = time();
			$errlog->active = 1;
			$errlog->error_id = $vkErr->getCode();
			$errlog->error_msg = $vkErr->getMessage();
			$errlog->captcha_sid = '';
			
			if($vkErr->getCode() == VkPhotoPostingErrorLogModel::NEED_CAPTCHA)
			{
				$mailEvent = new MailEvent();
				$mailEvent->actionVkNeedCaptcha();
				$errlog->captcha_sid = $vkErr->getCaptchaSid();
			}
			
			$errlog->save();
			echo "\tОшибка #".$vkErr->getCode().": ".$vkErr->getMessage();
		}
	}
	
	
	/**
	 * Рассылка письма о новых возможностях объявлений
	 * рассылается только тем пользователям, которые когда-либо публиковали объявление на сайте
	 * @param int $firstId - id c которого начинаем рассылку
	 * @param int $lastId - id которым заканчиваем рассылку
	 * @param string $listIds - список id разделенных запятой
	 * @throws Exception
	 */
	public function actionNewAnnouncementMailing($firstId=1, $lastId=1, $listIds = '')
	{
		$errorFileDir = dirname(__FILE__). DIRECTORY_SEPARATOR .'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'bash'.DIRECTORY_SEPARATOR.'NewAnnouncementMailing';
		try {
			if (!empty($listIds)) {
				$users = Yii::app()->db->createCommand()
						->select('t.id, t.email, t.name, t.hashed_password')
						->from('member t')
						->where('
							t.id IN ('.$listIds.')
						')
						->queryAll();
			}
			else {
				$users = Yii::app()->db->createCommand()
						->select('t.id, t.email, t.name')
						->from('member t')
						->join('announcement a', 't.id=a.member_id')
						->where('
							t.is_activated = 1
							AND t.is_removed = 0
							AND t.id BETWEEN :firstId AND :lastId
						', array(':firstId'=>$firstId, 'lastId'=>$lastId))
						->group('t.id')
						->queryAll();
			}


			$content = $this->renderFile(Yii::app()->basePath . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'mailBody' . DIRECTORY_SEPARATOR . 'commerce_2013_06_14.php', null, true);

			$mail = new PSPhpMailer();
			$mail->mailConnect();
			$mail->Subject = 'Размещайте яркую рекламу на "Фото.Сайте"';

			foreach ($users as $user) {

				$userId = $user['id'];

				$mail->ClearAddresses(); // сбрасываем все прошлые адреса

				$mail->Body = str_replace(array('#USER_EMAIL#'), array($user['email']), $content);
				$mail->AddAddress($user['email'], $user['name']);

				if($mail->Send()) {
					echo "\tOK - $userId\n\r";
				}
				else {
					echo "\tERR - $userId\\n\r";
					throw new Exception('Ошибка отправки письма');
				}
			}
		}
		catch (Exception $e) {
			if (empty($user)) $user = array();
			file_put_contents($errorFileDir . DIRECTORY_SEPARATOR . 'error.txt', print_r( array('user'=>$user, 'getMessage'=>$e->getMessage(), 'getCode'=>$e->getCode(), 'getFile'=>$e->getFile(), 'getLine'=>$e->getLine()),true), FILE_APPEND);
		}
	}



	public function actionAddToSocialPublicationQueue()
	{
		Yii::app()->socialPosting->addAllToQueue();
		echo "\tDone\n";
	}


	public function actionSocialPublicationToUserPage()
	{
		Yii::app()->socialPosting->sendAllFromQueue();
		$errors = Yii::app()->socialPosting->getErrors();

		if(!empty($errors))
		{
			echo "\tError:\n";
			foreach ($errors as $error) {
				echo "\t" . $error['queueId'] . ": " . $error['errorText'] . "\n";
			}
		}
		echo "\tDone\n";
	}


	/**
	 * Пометка старых записей со статусом на отправку как просроченных
	 */
	public function actionSetSocialPublicationExpired($period = 604800)
	{
		$criteria = new CDbCriteria(array(
			'condition' => 'status = 0 AND ctime < :time',
			'params' => array(
				':time' => time() - $period,
			),
		));
		SocialPostingQueue::model()->updateAll(array('status' =>  SocialPostingQueue::STATUS_EXPIRE), $criteria);
		echo "\tDone";
	}
	
	
	/**
	 * Проверка на наличие ошибок в логе рассылки в социальные сети
	 */
	public function actionSocialPublicationErrorSummary($period = 86400)
	{
		$criteria = new CDbCriteria(array(
			'condition' => 'status = :status AND ctime > :time',
			'params' => array(
				':status' => SocialPostingQueue::STATUS_ERROR,
				':time' => time() - $period,
			),
		));
		$errors = SocialPostingQueue::model()->findAll($criteria);
		if(!empty($errors))
		{
			$mailEvent = new MailEvent();
			$mailEvent->actionSocialPublicationErrorSummary($errors);
		}
		echo "\tDone";
	}

		
	/**
	 * Добавление последней активной фотографии пользователя в очередь на рассылку в соцсеть
	 */
	public function actionAddTestMemberToSocialPublicationQueue($memberId)
	{
		if(!is_numeric($memberId)) return;
		$criteria = new CDbCriteria(array(
			'with' => array(
				'member' => array(
					'joinType' => 'inner join'
				),
			),
			'together' => true,
			'scopes' => array('active'),
			'condition' => 't.member_id = :memberId',
			'params' => array(':memberId' => $memberId),
			'order' => 't.id DESC',
			'limit' => 1,
		));

		$photo = Photo::model()->find($criteria);
		if(!empty($photo))
		{
			Yii::app()->socialPosting->addEntryToQueue($photo);
		}
		echo "\tDone\n";
	}


	/**
	 * Синхронизация таблицы member_settings с таблицей member
	 */
	public function actionSyncMemberSettings()
	{
		Yii::app()->getDb()->createCommand('
		INSERT INTO member_settings (member_id)
			SELECT id FROM member
			WHERE id > (select MAX(member_id) from member_settings);
		')->execute();
	}


	/**
	 * Подсчет рейтинга альбомов
	 */
	public function actionUpdatePhotoSetsRating()
	{
		$sql_photos = "SELECT photo_id
						FROM photo2set
						INNER JOIN photo ON photo2set.photo_id=photo.id
						WHERE photo2set.set_id = :setId
						AND photo.is_removed = 0
						AND photo.is_blocked_owner = 0
						AND photo.category_id != ".PhotoCategory::$NuCategory."
						AND photo.is_adult = 0
						ORDER BY photo.recommendations_art DESC
						LIMIT 0,10";
		$command_photos = Yii::app()->getDb()->createCommand($sql_photos);

		$sql_photos_nu = "SELECT photo_id
						FROM photo2set
						INNER JOIN photo ON photo2set.photo_id=photo.id
						WHERE photo2set.set_id = :setId
						AND photo.is_removed = 0
						AND photo.is_blocked_owner = 0
						ORDER BY photo.recommendations_art DESC
						LIMIT 0,10";
		$command_photos_nu = Yii::app()->getDb()->createCommand($sql_photos_nu);

		$rating = array();
		foreach(PhotoSetRating::$rating_types as $type=>$typeName)
		{
			$row = array();
			$row[':type'] = $type;
			foreach(PhotoSetRating::$rating_periods as $period=>$periodName)
			{
				$row[':period'] = $period;
				for($nu=0; $nu<=1; $nu++)
				{
					$row[':nu'] = $nu;
					if($type=='total') {
						$result = PhotoSet::getTopByTotal($period, $nu);
					}
					else {
						$result = PhotoSet::getTopByXOT($type, $period, $nu);
					}
					foreach($result as $item)
					{
						if($item['avg_rating']>0)
						{
							if($nu)
							{
								$command_photos_nu->bindParam(":setId", $item['set_id']);
								$photos = $command_photos_nu->queryColumn();
							}
							else
							{
								$command_photos->bindParam(":setId", $item['set_id']);
								$photos = $command_photos->queryColumn();
							}
							$row[':photos'] = implode(',', $photos);	
							$row[':set_id'] = $item['set_id'];
							$row[':rating'] = $item['avg_rating'];
							$rating[] = $row;
						}
					}
				}	
			}
		}
		
		$transaction = Yii::app()->getDb()->beginTransaction();
		try
		{	
			//удаляем старый рейтинг
			Yii::app()->getDb()->createCommand('TRUNCATE TABLE photo_sets_rating')->execute();
			//записываем новый рейтинг
			$sql = "INSERT INTO photo_sets_rating (set_id, rating, type, period, with_nu, photos) VALUES (:set_id, :rating, :type, :period, :nu, :photos)";
			$command = Yii::app()->getDb()->createCommand($sql);
			foreach($rating as $item) {
				$command->execute($item);
			}
			
			$transaction->commit();
		}
		catch (Exception $e)
		{
			$transaction->rollback();
		}
		echo "\tDone";
	}


	public function actionMenuMailing($test = false)
	{
		$errorFileDir = dirname(__FILE__). DIRECTORY_SEPARATOR .'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'bash'.DIRECTORY_SEPARATOR.'MenuMailing';
		if (!is_dir($errorFileDir))
			mkdir($errorFileDir, 0775, true);

		try {

			$users = array(

				'menu_letter1' => array(
					3947, 5786, 15171, 15927, 40792, 49689, 79184, 79542, 84792, 86851, 89559, 93247, 122694, 124737, 136223, 163405, 167883, 172650, 172827, 217074, 237967, 238425, 250267, 254205, 259017, 265884, 268335, 274339, 276989, 283014, 283176, 285715, 285723, 290207, 292561, 296435, 296521, 297046, 300473, 302309, 302425, 302654, 321945, 324500, 325619, 325677, 327461, 330369, 334074, 334493, 338734, 339993, 341845, 343476, 346277, 349285, 356860, 358097, 358570, 359630, 360272, 361839, 365497, 366694, 369390, 370077, 371499, 372778, 372852, 377121, 380197, 382062, 382354, 385596, 385802, 386000, 386087, 389177, 390481, 391397, 392974, 393341, 394548, 398276, 399178, 399229, 399925, 399956, 400343, 400856, 403943, 404075, 407576, 409884, 409925, 410480, 410621, 411255, 413274, 414009, 414714, 414907, 415632, 418173, 420568, 420660, 421346, 422102, 422130, 422272, 422351, 422364, 422388, 422451, 422644, 422992, 423034, 423056, 423138, 423219, 423262, 423275, 423313, 423348, 423362, 423369, 423374, 423396, 423415, 423416, 423430, 423483, 423506, 423518, 423545, 423571, 423601, 423604, 423605, 423617, 423629, 423727, 423749, 423758, 423832, 423844, 423867, 423868, 423873, 423907, 423931, 423943, 423950, 423988, 423995, 423999, 424008, 424024, 424033, 424043, 424046, 424048, 424067, 424080, 424088, 424111, 424125, 424128, 424138, 424206, 424207, 424210, 424221, 424226, 424233, 424271, 424298
				),
				'menu_letter2' => array(
					1253, 386047, 423363, 423502, 423838, 423910, 423926, 423970, 424148
				),
				'menu_letter3' => array(
					417990, 424118
				)
			);

			$mailer = new PSPhpMailer();
			$mailer->mailConnect();
			$mailer->Subject = 'Проект: «В объективе: все заведения Москвы»';

			foreach ($users as $template => $userGroup) {
				$sql = Yii::app()->getDb()->createCommand()->select('t.id, t.nick, t.name, t.login, t.email')->from('member t');
				if ($test == true) {
					$members = $sql->where('t.id IN (406348)')->queryAll();
				}
				else {
					$members = $sql->where('t.id IN ('.implode(',', $userGroup).')')->queryAll();
				}

				echo "\n\ntype - $template\n";

				foreach ($members as $member) {
					$mailer->ClearAddresses(); // сбрасываем все прошлые адреса
					$mailer->AddAddress($member['email'], $member['name']);
					$mailer->Body = $this->renderFile(Yii::app()->basePath . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'mailBody' . DIRECTORY_SEPARATOR . $template .'UnderWaterStatWidget.php', array('member'=>$member), true);;

					if($mailer->Send()) {
						echo "\tOK - {$member['id']}";
					}
					else {
						echo "\tERR - {$member['id']}";
						throw new Exception('Ошибка отправки письма');
					}
				}

				echo "\n";
			}
		}
		catch (Exception $e) {
			echo "\tERR";
			file_put_contents($errorFileDir . DIRECTORY_SEPARATOR . 'error.txt', print_r( array('getMessage'=>$e->getMessage(), 'getCode'=>$e->getCode(), 'getFile'=>$e->getFile(), 'getLine'=>$e->getLine()),true), FILE_APPEND);
			throw $e;

		}
	}


	/**
	 * Проставление топ флагов фотографиям
	 * @param $limit лимит на попадане в топ
	 * @param $nu режим с ню / без ню
	 */
	public function actionRankPhotosByCurrentRating($limit=21, $nu=false)
	{
		$time = time();
		
		$criteria = new CDbCriteria(array(
			'with' => array(
				'photo' => array(
					'joinType' => 'inner join',
					'scopes' => array('isNotHideTopFlags', 'isNotInBlackList', 'active'),
					'select' => false,
				),
			),
			'condition' => 't.rating >= :rating AND t.photo_ctime >= :time',
			'order' => 't.rating DESC, t.photo_ctime DESC',
			'params' => array(
				':rating' => Yii::app()->params['photo']['minimumRatingForApplicationPhotoListAction'],
				':time' =>  $time - Yii::app()->params['photo']['photo_anonymous_period'],
			),
			'limit' => $limit,
		));

		if($nu==false) {
			$criteria->with['photo']['scopes'][] = 'withoutNu';
		}

		$currentRating = PhotoCurrentRating::model()->findAll($criteria) ;

		/** @var $item PhotoCurrentRating */
		foreach ($currentRating as $i=>$item) {
			//первому фото присваиваем метку is_top_1
			if($i==0) {
				$item->is_top_20 = 0;
				$item->is_top_5 = 0;
				$item->is_top = 1;
				$item->last_rank_time = $time;
			}
			//следующим 5 присваиваем метку is_top_5
			elseif($i<=5) {
				$item->is_top_5 = 1;
				$item->last_rank_time = $time;
			}
			//остальным присваиваем метку is_top_20
			else {
				$item->is_top_20 = 1;
				$item->last_rank_time = $time;
			}
			if ($item->save()) {
				echo "\tOK - {$item->id}";
			}
			else {
				echo "\tERROR - {$item->id}";
			}
		}
	}
	
	
	/**
	 * Перенос записей из photo_current_rating в photo_current_rating_archive
	 */
	public function actionMoveOldPhotoRatingsToArchive()
	{
		$time = time() - Yii::app()->params['photo']['photo_anonymous_period'];
		
		$criteria = new CDbCriteria(array(
			'condition' => 't.rating >= :rating AND t.photo_ctime < :time AND (t.is_top=1 OR t.is_top_5=1 OR t.is_top_20=1)',
			'params' => array(
				':rating' => Yii::app()->params['photo']['minimumRatingForApplicationPhotoListAction'],
				':time' =>  $time,
			),
		));
		
		$currentRating = PhotoCurrentRating::model()->findAll($criteria);
		/** @var $item PhotoCurrentRating */
		foreach($currentRating as $item) {
			//переносим в архивную таблицу
			$archive = PhotoCurrentRatingArchive::model()->findByPk($item->id);
			if(empty($archive)) {
				$archive = new PhotoCurrentRatingArchive();
				$archive->setAttributes($item->attributes);
				if ($archive->save()) {
					echo "\tOK - {$archive->id}";
				}
				else {
					echo "\tERROR - {$archive->id}";
				}
			}
			//проставляем топ флаги у фото
			Photo::model()->updateByPk($item->id, array('is_top'=>$item->is_top, 'is_top_5'=>$item->is_top_5, 'is_top_20'=>$item->is_top_20));
			// сброс кеша в старом коде
			if (_ENVIRONMENT == 'production') {
				Yii::app()->limbCache->delete('photo_new_' . $item->id);
			}
		}
		//удаляем все старые записи из таблицы рейтинга
		PhotoCurrentRating::model()->deleteAll('photo_ctime < :time', array(':time' => $time));
	}

	
	/**
	 * Проверка статусов пополнения кошелька через робокассу 
	 */
	public function actionRobokassaCheck()
	{
		$criteria = new CDbCriteria(array(
			'condition' => 't.status NOT IN(10, 60, 100) AND t.ctime BETWEEN :old_time AND :new_time',
			'params' => array(
				':new_time' =>  time() - Yii::app()->params['robokassa']['min_check_time'],
				':old_time' =>  time() - Yii::app()->params['robokassa']['max_check_time'],
			),
		));
		
		$payments = CashRobokassaPayment::model()->findAll($criteria);
		/** @var $item CashRobokassaPayment */
		foreach($payments as $item) {
			$item->checkStatus();
		}
	}


	/**
	 * Удаление записей из таблицы недогруженных фото
	 */
	public function actionDeleteOldUploadedPhoto()
	{
		$criteria = new CDbCriteria(array(
			'condition' => 'ctime < :time',
			'params' => array(
				':time' => time() - Yii::app()->params['photoUpload']['tmpPhotoLiveTime'],
			),
		));
		UploadedPhoto::model()->deleteAll($criteria);

		echo "\tdone!";
	}


	public function actionSyncCatalogPhotos()
	{
		$photoIds = Yii::app()->getDb()->createCommand('
						SELECT t.photo_id
						FROM link_photo_print_set t
						LEFT JOIN canvas_catalog_photo pc ON pc.photo_id = t.photo_id
						where pc.photo_id IS NULL
						group by t.photo_id
					')->queryAll();

		foreach ($photoIds as $photoId) {

			$canvasCatalogPhoto = new CanvasCatalogPhoto();
			$canvasCatalogPhoto->photo_id = $photoId['photo_id'];
			$canvasCatalogPhoto->chosen = 0;
			$canvasCatalogPhoto->ctime = time();
			if (!$canvasCatalogPhoto->save()) {
				echo "\n\n" . print_r($canvasCatalogPhoto->errors, true) . "\n\n";
			}
		}

		echo 'done';
	}

	
	/**
	 * Добавление заказов в очередь на отправку печатникам
	 */
	public function actionAddToCanvasPrintApiQueue()
	{
		$criteria = new CDbCriteria(array(
			'condition' => 'status = :status AND member_finish_time < :time AND payment_type != :payment_type AND is_added_to_api_queue != 1',
			'params' => array(
				':status' => CanvasPrintApiQueue::STATUS_NEW,
				':time' => time() - Yii::app()->params['canvasPrint']['periodAddToQueue'],
				':payment_type' => CanvasPrintOrder::PAYMENT_ONLINE,
			),
		));
		$orders = CanvasPrintOrder::model()->findAll($criteria);
		foreach ($orders as $order) {
			echo "\n" . $order->id . "\n";
			CanvasPrintApiQueue::addToQueue($order->id, CanvasPrintApiQueue::TYPE_POST_ORDER, Yii::app()->params['canvasPrint']['orderPartner']['application']);
			$order->is_added_to_api_queue = 1;
			$order->save();
		}
		echo "\tDone";
	}
	
	
	/**
	 * Отсылка заказов печати на холсте партнерам
	 */
	public function actionSendCanvasPrintApiQueue($limit=10)
	{
		Yii::import('application.modules.api.vendors.ApiJsonRPC', true);
		Yii::import('application.modules.api.vendors.ApiJsonRpcClient', true);
		Yii::import('application.modules.api.components.ApiBaseController', true);
		
		
		$criteria = new CDbCriteria(array(
			'condition' => 't.status = :status',
			'params' => array(
				':status' => CanvasPrintApiQueue::STATUS_NEW,
			),
			'limit' => $limit,
			'order' => 't.id asc',
		));

		/** @var CanvasPrintApiQueue[]  $queue */
		$queue = CanvasPrintApiQueue::model()->findAll($criteria);
		
		//меняем статус у выбранных записей на taken
		foreach($queue as $item) {
			$item->status = CanvasPrintApiQueue::STATUS_TAKEN;
			$item->utime = time();
			$item->save();
		}
		
		/** @var $item CanvasPrintApiQueue */
		foreach($queue as $item) {
			try
			{
				// заказ с которым работаем в данный момент
				$item->status = CanvasPrintApiQueue::STATUS_SENDING;
				$item->utime = time();
				$item->save();
				
				if($item->type==CanvasPrintApiQueue::TYPE_POST_ORDER) {
					CanvasPrintOrderHandler::apiSendPostOrder($item->order_id, $item->api_application_id);
				}
				elseif($item->type==CanvasPrintApiQueue::TYPE_UPDATE_ORDER) {
					CanvasPrintOrderHandler::apiSendUpdateOrder($item->order_id, $item->api_application_id);
				}

				$item->status = CanvasPrintApiQueue::STATUS_DONE;
				$item->utime = time();
				$item->save();
				echo "\tЗаказ №".$item->order_id." отправлен\n\n";
			}
			catch(CanvasPrintApiException $error)
			{
				$item->status = CanvasPrintApiQueue::STATUS_ERROR;
				$item->error_msg = 'CanvasPrintApiException #'.$error->getCode().': '.$error->getMessage();
				$item->utime = time();
				$item->save();

				$mailEvent = new MailEvent();
				$mailEvent->actionCanvasPrintApiError($item->canvasPrintOrder, $error->getMessage(), $error->getCode());

				echo "\tОшибка CanvasPrintApiException отправки заказа №".$item->order_id.": #".$error->getCode().": ".$error->getMessage() . "\n\n";
			}
			catch(ApiException $error)
			{
				$item->status = CanvasPrintApiQueue::STATUS_ERROR;
				$item->error_msg = 'ApiException #'.$error->getCode().': '.$error->getMessage();
				$item->utime = time();
				$item->save();

				$mailEvent = new MailEvent();
				$mailEvent->actionCanvasPrintApiError($item->canvasPrintOrder, $error);

				echo "\tОшибка ApiException отправки заказа №".$item->order_id.": #".$error->getCode().": ".$error->getMessage() . "\n\n";
			}
			catch(ClientApiException $error)
			{
				$item->status = CanvasPrintApiQueue::STATUS_ERROR;
				$item->error_msg = 'ClientApiException #'.$error->getCode().': '.$error->getMessage();
				$item->utime = time();
				$item->save();

				$mailEvent = new MailEvent();
				$mailEvent->actionCanvasPrintApiError($item->canvasPrintOrder, $error);

				echo "\tОшибка ClientApiException отправки заказа №".$item->order_id.": #".$error->getCode().": ".$error->getMessage() . "\n\n";
			}
			catch(CException $error)
			{
				$item->status = CanvasPrintApiQueue::STATUS_ERROR;
				$item->error_msg = 'CException #'.$error->getCode().': '.$error->getMessage();
				$item->utime = time();
				$item->save();
				echo "\tОшибка отправки заказа №".$item->order_id.": #".$error->getCode().": ".$error->getMessage() . "\n\n";

				$mailEvent = new MailEvent();
				$mailEvent->actionCanvasPrintApiError($item->canvasPrintOrder, $error);
			}
			
		}
		echo "\tDone\n";
	}


	/**
	 * Сброс статусов "зависших" записей в очереди на отправку заказов печати холста
	 */
	public function actionResetTakenCanvasPrintApiQueue($period = 3600)
	{
		$criteria = new CDbCriteria(array(
			'condition' => 'status = :status AND utime < :utime',
			'params' => array(
				':status' => CanvasPrintApiQueue::STATUS_TAKEN,
				':utime' => time() - $period,
			),
		));
		CanvasPrintApiQueue::model()->updateAll(array('status' => CanvasPrintApiQueue::STATUS_NEW), $criteria);
		echo "\tDone";
	}




	/**
	 * Отправка писем об изменении статуса заказа
	 */
	public function actionSendCanvasPrintMails($limit=100)
	{
		// выбираем записи со временем отправки меньше тукущего времени
		$criteria = new CDbCriteria(array(
			'condition' => 't.status = :status AND t.send_time <= :send_time',
			'params' => array(
				':status' => CanvasPrintApiQueue::STATUS_NEW,
				':send_time' => time(),
			),
			'limit' => $limit,
			'order' => 't.send_time asc',
		));

		/** @var CanvasPrintSendMailQueue[]  $queue */
		$queue = CanvasPrintSendMailQueue::model()->findAll($criteria);

		//меняем статус у выбранных записей на taken
		foreach($queue as $item) {
			$item->status = CanvasPrintApiQueue::STATUS_TAKEN;
			$item->utime = time();
			$item->save();
		}

		$mailEvent = new MailEvent();
		foreach($queue as $item) {
			try {
				// заказ с которым работаем в данный момент
				$item->status = CanvasPrintApiQueue::STATUS_SENDING;
				$item->utime = time();
				$item->save();

				// отправка письма
				$mailEvent->actionCanvasPrintOnStatusChange($item->canvasPrintOrder);

				$item->status = CanvasPrintApiQueue::STATUS_DONE;
				$item->utime = time();
				$item->save();
				echo "\tЗаказ №".$item->order_id." письмо отправлено\n";
			}
			catch(CException $error) {
				$item->status = CanvasPrintApiQueue::STATUS_ERROR;
				$item->error_msg = 'CException #'.$error->getCode().': '.$error->getMessage();
				$item->utime = time();
				$item->save();
				echo "\tОшибка отправки заказа №".$item->order_id.": #".$error->getCode().": ".$error->getMessage() . "\n\n";
			}
		}
		echo "\tDone\n";
	}
	
}