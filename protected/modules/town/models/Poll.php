<?php

/**
 * This is the model class for table "{{poll}}".
 *
 * The followings are the available columns in table '{{poll}}':
 * @property string $id
 * @property string $title
 * @property string $description
 * @property integer $status
 *
 * The followings are the available model relations:
 * @property PollChoice[] $choices
 * @property PollVote[] $votes
 */
class Poll extends CActiveRecord
{
  /**
   * @var integer representing a closed poll status
   */
  const STATUS_CLOSED = 0;

  /**
   * @var integer representing an open poll status
   */
  const STATUS_OPEN = 1;

  /**
   * Returns the static model of the specified AR class.
   * @return Poll the static model class
   */
  public static function model($className=__CLASS__)
  {
    return parent::model($className);
  }

  /**
   * @return string the associated database table name
   */
  public function tableName()
  {
    return '{{poll}}';
  }

  /**
   * @return array validation rules for model attributes.
   */
  public function rules()
  {
    return array(
      array('title', 'required'),
      array('status', 'numerical', 'integerOnly'=>true),
      array('title', 'length', 'max'=>255),
      array('description', 'safe'),
      array('title, description, status', 'safe', 'on'=>'search'),
    );
  }

  /**
   * @return array relational rules.
   */
  public function relations()
  {
    return array(
      'choices' => array(self::HAS_MANY, 'PollChoice', 'poll_id'),
      'votes' => array(self::HAS_MANY, 'PollVote', 'poll_id'),
      'totalVotes' => array(self::STAT, 'PollChoice', 'poll_id', 'select' => 'SUM(votes)'),
    );
  }

  /** 
   * @return array additional query scopes
   */
  public function scopes()
  {
    return array(
      'open'=>array(
        'condition'=>'status='. self::STATUS_OPEN,
       ),  
      'closed'=>array(
        'condition'=>'status='. self::STATUS_CLOSED,
       ),  
       'latest'=>array(
        'order'=>'id DESC',
       ),  
    );  
  }

  /**
   * @return array customized attribute labels (name=>label)
   */
  public function attributeLabels()
  {
    return array(
      'id' => 'ID',
      'title' => Yii::t('Poll', 'Title'),
      'description' => Yii::t('Poll', 'Description'),
      'status' => Yii::t('Poll', 'Status'),
    );
  }

  /**
   * @return array customized status labels
   */
  public function statusLabels()
  {
    return array(
      self::STATUS_CLOSED => Yii::t('Poll', 'Closed'),
      self::STATUS_OPEN   => Yii::t('Poll', 'Open'),
    );
  }

  /**
   * Returns the text label for the specified status.
   */
  public function getStatusLabel($status)
  {
    $labels = self::statusLabels();

    if (isset($labels[$status])) {
      return $labels[$status];
    }

    return $status;
  }

  /**
   * Retrieves a list of models based on the current search/filter conditions.
   * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
   */
  public function search()
  {
    $criteria=new CDbCriteria;

    $criteria->compare('title',$this->title,true);
    $criteria->compare('description',$this->description,true);
    $criteria->compare('status',$this->status);

    return new CActiveDataProvider($this, array(
      'criteria'=>$criteria,
    ));
  }

  /**
   * Determine if a user can vote on a Poll.
   */
  public function userCanVote()
  {
    if ($this->status == self::STATUS_CLOSED) return FALSE;

	$voteCookiesQuestionIds = !empty($_COOKIE['vote_questions']) ? $_COOKIE['vote_questions'] : '';
	$voteCookiesQuestionIdsArr = explode(',',$voteCookiesQuestionIds);
	return !in_array($this->id, $voteCookiesQuestionIdsArr);
  }

  /**
   * Determine if a user can cancel their vote.
   * @param PollVote instance
   */
  public function userCanCancelVote($pollVote)
  {
    if (!$pollVote->id || $this->status == self::STATUS_CLOSED) {
      return FALSE;
    }

    $isGuest = Yii::app()->user->isGuest;
    $guestsCanCancel = Yii::app()->params['poll']['ipRestrict'] && Yii::app()->params['poll']['allowGuestCancel'];

    if (!$isGuest || ($isGuest && $guestsCanCancel)) {
      return TRUE;
    }

    return FALSE;
  }
}
