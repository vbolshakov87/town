<?php
/**
 * Модель для сущностей публикаций
 * @method PublicationActiveRecord search()
 * @property integer $user_group_id
 */
class PublicationActiveRecord extends ActiveRecord
{
	protected $_userGroupNames = null;

	/**
	 * Скоуп для доступа групп к статьям
	 * @return $this
	 */
	public function scopeByGroupAccess()
	{
		if (!Yii::app()->getUser()->isAdmin()) {
			$this->getDbCriteria()->mergeWith(array(
				'with' => array(
					'linkUserGroups' => array(
						'joinType' => 'inner join',
						'select' => false,
					),
				),
				'condition' => 'linkUserGroups.user_id = :user_id AND linkUserGroups.user_group_id != :stopGroupId',
				'params' => array(
					':user_id' => Yii::app()->getUser()->getId(),
					':stopGroupId' => UserGroup::GROUP_SITE,
				),
			));
		}

		return $this;
	}


	/**
	 * Retrieves a list of models based on the current search/filter conditions on admin page
	 * @return CActiveDataProvider
	 */
	public function adminSearch()
	{
		if (empty($this->user_group_id))
			$this->user_group_id = null;

		/** @var CActiveDataProvider $provider */
		$provider = $this->search();
		$provider->criteria->together = true;


		if (!empty($_GET[get_class($this)]['id'])) {
			$this->id = $_GET[get_class($this)]['id'];
			$provider->criteria->addCondition('t.id = :id');
			$provider->criteria->params[':id'] = $this->id;
		}


		//$provider->criteria->scopes[] = 'scopeByGroupAccess';

		return $provider;
	}


	/**
	 * Получение названия группы пользователя по user_group_id
	 * @return string
	 */
	public function getGroupNameById()
	{
		if ($this->_userGroupNames == null) {
			/** @var UserGroup[] $nameModels */
			$nameModels = UserGroup::model()->findAll();
			foreach ($nameModels as $nameModel) {
				$this->_userGroupNames[$nameModel->id] = $nameModel->name;
			}
		}

		if (!empty($this->user_group_id) && !empty($this->_userGroupNames[$this->user_group_id]))
			return $this->_userGroupNames[$this->user_group_id];

		return '';
	}


	protected function afterSave()
	{
		parent::afterSave();

		if (in_array(get_class($this), array('Story', 'PhotoStory', 'Figure'))) {
			$essence = $this->getEssence();

			if ($this->active == 1) {
				$document = Document::model()->findByAttributes(array('essence'=>$essence, 'essence_id' => $this->id));
				if (empty($document))
					$document = new Document();

				$document->essence = $essence;
				$document->essence_id = $this->id;
				$document->create_time = $this->create_time;
				$document->update_time = $this->update_time;
				$document->title = $this->title;
				$document->brief = $this->brief;
				$document->content = $this->content;
				$document->image = $this->image;
				$document->image_top_1 = !empty($this->image_top_1) ? $this->image_top_1 : $this->image;
				$document->image_top_3 = !empty($this->image_top_3) ? $this->image_top_3 : $this->image;
				$document->main_page = $this->main_page;
				$document->save();
			}
			else {
				Document::model()->deleteAllByAttributes(array('essence'=>$essence, 'essence_id' => $this->id));
			}
		}
	}


} 