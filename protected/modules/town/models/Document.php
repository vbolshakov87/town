<?php
/**
 * Модель всех сущностей публикаций
 * @method Document mainPage()
 */
class Document extends BaseDocument
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Document the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


	public function scopes()
	{
		$tableAlias = $this->getTableAlias(false, false);
		return array(
			'mainPage' => array(
				'condition' => $tableAlias.'.main_page = 1'
			),
		);
	}

    public function relations()
    {
        return array(
            'photoStory' => array(self::BELONGS_TO, 'PhotoStory', 'essence_id'),
            'story' => array(self::BELONGS_TO, 'Story', 'essence_id', 'on' => 'document.essence = "story"'),
            'figure' => array(self::BELONGS_TO, 'Figure', 'essence_id', 'on' => 'document.essence = "figure"'),
        );
    }


	/**
	 * Url детальной страницы сущности
	 * @return string
	 */
	public function createUrl()
	{
		return Yii::app()->createUrl($this->getControllerId().'/view', array('id'=>$this->essence_id));
	}


	public function getControllerId()
	{
		if ($this->essence == 'photo_story')
			return 'photoStory';
		else
			return $this->essence;
	}


	/**
	 * Ключ тегированного кеша сущности
	 * @param $essence
	 * @param $essenceId
	 * @return string
	 */
	public static function cacheKey($essence, $essenceId)
	{
		return __CLASS__.'_'.$essence.'_'.$essenceId;
	}


	/**
	 * Изображение отдельной сущности
	 * @param $type
	 * @param string $attribute
	 * @param bool $create
	 * @param null $modelType
	 * @return mixed
	 */
	public function getDocumentImageSrc($type, $attribute='image', $create = false, $modelType=null)
	{
		$essence = $this->getControllerId();
		$type = $essence.'/'.$type;
		if (empty($modelType))
			$modelType = strtolower($essence);
       // print '<pre>'; print_r(array($type, $attribute, $create, $modelType)); print '</pre>';
		return parent::getImageSrc($type, $attribute, $create, $modelType);
	}


    public function getEssenceTitleLink()
    {
        switch ($this->essence) {
            case 'story':
                $label = Yii::t('all', 'Stories');
                break;
            case 'figure':
                $label = Yii::t('all', 'Figures');
                break;
            case 'photo_story':
                $label = Yii::t('all', 'Photo stories');
                break;
            default:
                print '<pre>'; print_r($this->essence); print '</pre>'; exit;
        }

        return array(
            'link' => Yii::app()->createUrl($this->getControllerId().'/index'),
            'label' => $label
        );
    }
} 