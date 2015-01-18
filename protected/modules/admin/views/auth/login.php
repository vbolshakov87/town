<?php
/* @var $this AdminController */
/* @var $model AdminLoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Login';

?>


<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'login-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
	'htmlOptions' => array('class'=>'form-signin')
)); ?>
<h2 class="form-signin-heading">Пожалуйста авторизуйтесь</h2>
<?php echo $form->textField($model,'login', array('class'=>'input-block-level form-control',	'placeholder' => $model->getAttributeLabel('login') )); ?>
<?php echo $form->passwordField($model,'password', array('class'=>'input-block-level form-control',
	'placeholder' => $model->getAttributeLabel('password') )); ?>
    <label class="checkbox">
	    <?php echo $form->checkBox($model,'rememberMe'); ?> <?=$model->getAttributeLabel('rememberMe')?>
    </label>
	<?php echo CHtml::submitButton('Авторизоваться', array('class' => 'btn btn-large btn-primary',
	'data-loading-text' => 'Обработка...')); ?>
<?php $this->endWidget(); ?>
<script>
	$(document).ready(function(){
        $('.btn-primary').click(function(){
            $(this).button('loading');
        });
	});
</script>