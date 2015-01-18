<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
  'id'=>'poll-form',
	'htmlOptions' => array(
		'class' => 'form-horizontal',
		'enctype' => 'multipart/form-data',
	),
  //'enableAjaxValidation'=>TRUE,
)); ?>

  <p class="note"><?=Yii::t('all', 'Fields with <span class="required">*</span> are required.')?></p>

  <?php echo $form->errorSummary($model); ?>

  <div class="form-group row <?if (!empty($model->errors['title'])) :?> error<?endif;?>">
    <?php echo $form->labelEx($model,'title', array('class'=>'col-sm-2 control-label')); ?>
	  <div class="col-sm-10">
	    <?php echo $form->textField($model,'title',array('class'=>'form-control')); ?>
	    <?php echo $form->error($model,'title'); ?>
	  </div>
  </div>

  <div class="form-group row <?if (!empty($model->errors['description'])) :?> error<?endif;?>">
    <?php echo $form->labelEx($model,'description', array('class'=>'col-sm-2 control-label')); ?>
	  <div class="col-sm-10">
	    <?php echo $form->textArea($model,'description',array('class'=>'form-control','rows' => 7)); ?>
	    <?php echo $form->error($model,'description'); ?>
	  </div>
  </div>

  <div class="form-group row <?if (!empty($model->errors['status'])) :?> error<?endif;?>">
    <?php echo $form->labelEx($model,'status', array('class'=>'col-sm-2 control-label')); ?>
	  <div class="col-sm-10">
	    <?php echo $form->dropDownList($model,'status',$model->statusLabels(), array('class'=>'form-control')); ?>
	    <?php echo $form->error($model,'status'); ?>
	  </div>
  </div>

  <h3><?=Yii::t('Poll', 'Choices')?></h3>

  <table id="poll-choices" class="table table-bordered">
    <thead>
      <th><?=Yii::t('Poll', 'Weight')?></th>
      <th><?=Yii::t('Poll', 'Label')?></th>
      <th><?=Yii::t('Poll', 'Actions')?></th>
    </thead>
    <tbody>
    <?php
      $newChoiceCount = 0;
      foreach ($choices as $choice) {
        $this->renderPartial('/pollchoice/_formChoice', array(
          'id' => isset($choice->id) ? $choice->id : 'new'. ++$newChoiceCount,
          'choice' => $choice,
        ));
      }
      ++$newChoiceCount; // Increase once more for Ajax additions
    ?>
    <tr id="add-pollchoice-row">
      <td class="weight"></td>
      <td class="label">
        <?php echo CHtml::textField('add_choice', '', array('size'=>60, 'id'=>'add_choice')); ?>
        <div class="errorMessage" style="display:none">You must enter a label.</div>
      </td>
      <td class="actions">
        <a href="#" id="add-pollchoice"><?=Yii::t('Poll', 'Add Choice')?></a>
      </td>
    </tr>
    </tbody>
  </table>

  <div class="row buttons">
    <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('all', 'Create') : Yii::t('all', 'Save'), array('class'=>'btn btn-primary', 'name'=>'save')); ?>
  </div>

<?php $this->endWidget(); ?>

</div><!-- form -->

<?php
$callback = Yii::app()->createUrl('/admin/pollchoice/ajaxcreate');
$js = <<<JS
var PollChoice = function(o) {
  this.target = o;
  this.label  = jQuery(".label input", o);
  this.weight = jQuery(".weight select", o);
  this.errorMessage = jQuery(".errorMessage", o);

  var pc = this;

  pc.label.blur(function() {
    pc.validate();
  });
}
PollChoice.prototype.validate = function() {
  var valid = true;

  if (this.label.val() == "") {
    valid = false;
    this.errorMessage.fadeIn();
  }
  else {
    this.errorMessage.fadeOut();
  }

  return valid;
}

var newChoiceCount = {$newChoiceCount};
var addPollChoice = new PollChoice(jQuery("#add-pollchoice-row"));

jQuery("tr", "#poll-choices tbody").each(function() {
  new PollChoice(jQuery(this));
});

jQuery("#add-pollchoice").click(function() {
  if (addPollChoice.validate()) {
    jQuery.ajax({
      url: "{$callback}",
      type: "POST",
      dataType: "json",
      data: {
        id: "new"+ newChoiceCount,
        label: addPollChoice.label.val()
      },
      success: function(data) {
        addPollChoice.target.before(data.html);
        addPollChoice.label.val('');
        new PollChoice(jQuery('#'+ data.id));
      }
    });

    newChoiceCount += 1;
  }

  return false;
});
JS;

Yii::app()->clientScript->registerCoreScript('jquery');
Yii::app()->clientScript->registerScript('pollHelp', $js, CClientScript::POS_END);
?>
