<?/**
 * @var $form  CActiveForm
 * @var $formModel LoginForm
 */?>
<div class="login">
	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'login-form',
		'action' => Yii::app()->createUrl('auth/login'),
		'enableAjaxValidation'=>true,
	)); ?>
		<h2>Привет, дайвер!</h2>
		<strong>Войди под своим аккаунтом</strong>

		<div class="row">
			<?php echo $form->textField($formModel,'email', array('class'=> 'inpblue', 'placeholder' => 'Логин или e-mail', 'required')); ?>
			<?php echo $form->error($formModel,'email'); ?>
		</div>
		<div class="row">
			<?php echo $form->passwordField( $formModel,'password', array('type' => 'password', 'class'=> 'inpblue', 'placeholder' => 'Пароль', 'required')); ?>
			<?php echo $form->error($formModel,'password'); ?>
		</div>

		<?php echo CHtml::submitButton('Войти', array('name' => 'l', 'class' => 'button')); ?>
		<?$this->widget('EAuthWidget');?>

		<p class="clearfix">
			<?php echo $form->checkBox($formModel,'rememberMe', array('id' => 'login-remember')); ?>
			<label for="login-remember">Запомнить меня</label>
			<a href="#" class="right">Восстановление пароля</a>
		</p>
	<?php $this->endWidget(); ?>
</div>