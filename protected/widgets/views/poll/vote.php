<div class="vote-aside">

<?php $form=$this->beginWidget('CActiveForm', array(
  'id'=>'portlet-poll-form',
  'enableAjaxValidation'=>false,
)); ?>

  <div class="row">
    <?php $template = '<div class="row-choice clearfix"><div class="form-radio">{input}</div><div class="form-label">{label}</div></div>'; ?>
    <?php echo $form->radioButtonList($userVote,'choice_id',$choices,array(
      'template'=>$template,
      'separator'=>'',
      'name'=>'PortletPollVote_choice_id')); ?>
    <?php echo $form->error($userVote,'choice_id'); ?>
  </div>

  <?php echo CHtml::submitButton(Yii::t('Poll', 'Vote'), array('class' => 'btn btn-small')); ?>

<?php $this->endWidget(); ?>

</div><!-- form -->
