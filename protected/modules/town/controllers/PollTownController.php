<?php

class PollTownController extends FrontController
{

	public $layout = 'page';

  /**
   * Displays a particular model.
   * @param integer $id the ID of the model to be displayed
   */
  public function actionView($id)
  {
    $model = $this->loadModel($id);

    if (Yii::app()->params['poll']['forceVote'] && $model->userCanVote()) {
      $this->redirect(array('vote', 'id' => $model->id)); 
    }
    else {
      $userVote = $this->loadVote($model);
      $userChoice = $this->loadChoice($model, $userVote->choice_id);

      $this->render('view', array(
        'model' => $model,
        'userVote' => $userVote,
        'userChoice' => $userChoice,
        'userCanCancel' => $model->userCanCancelVote($userVote),
      ));
    }
  }

  /**
   * Vote on a poll.
   * If vote is successful, the browser will be redirected to the 'view' page.
   * @param integer $id the ID of the model to vote on
   */
  public function actionVote($id)
  {
    $model = $this->loadModel($id);
    $vote = new PollVote;

    if (!$model->userCanVote())
      $this->redirect(array('view', 'id' => $model->id));

    if (isset($_POST['PollVote'])) {
      $vote->attributes = $_POST['PollVote'];
      $vote->poll_id = $model->id;
      if ($vote->save())
        $this->redirect(array('view', 'id' => $model->id));
    }

    // Convert choices to form options list
    $choices = array();
    foreach ($model->choices as $choice) {
      $choices[$choice->id] = CHtml::encode($choice->label);
    }

    $this->render('vote', array(
      'model' => $model,
      'vote' => $vote,
      'choices' => $choices,
    ));
  }



  /**
   * Lists all models.
   */
  public function actionIndex()
  {
    $dataProvider=new CActiveDataProvider('Poll');

    $this->render('index',array(
      'dataProvider'=>$dataProvider,
    ));
  }




  /**
   * Returns the data model based on the primary key given in the GET variable.
   * If the data model is not found, an HTTP exception will be raised.
   * @param integer the ID of the model to be loaded
   */
  public function loadModel($id)
  {
    $model=Poll::model()->with('choices','votes')->findByPk($id);
    if($model===null)
      throw new CHttpException(404,'The requested page does not exist.');
    return $model;
  }

  /**
   * Returns the PollChoice model based on primary key or a new PollChoice instance.
   * @param Poll the Poll model 
   * @param integer the ID of the PollChoice to be loaded
   */
  public function loadChoice($poll, $choice_id)
  {
    if ($choice_id) {
      foreach ($poll->choices as $choice) {
        if ($choice->id == $choice_id) return $choice;
      }
    }

    return new PollChoice;
  }

  /**
   * Returns the PollVote model based on primary key or a new PollVote instance.
   * @param object the Poll model 
   */
  public function loadVote($model)
  {
    $userId = (int) Yii::app()->user->id;
    $isGuest = Yii::app()->user->isGuest;

    foreach ($model->votes as $vote) {
      if ($vote->user_id == $userId) {
        if (Yii::app()->params['poll']['ipRestrict'] && $isGuest && $vote->ip_address != $_SERVER['REMOTE_ADDR'])
          continue;
        else
          return $vote;
      }
    }

    return new PollVote;
  }

  /**
   * Performs the AJAX validation.
   * @param CModel the model to be validated
   */
  protected function performAjaxValidation($model)
  {
    if(isset($_POST['ajax']) && $_POST['ajax']==='poll-form')
    {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }
  }
}
