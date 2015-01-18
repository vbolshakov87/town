<?
/* @var $form CActiveForm */
/* @var $notActivatedSocialMember */
/* @var $loginForm LoginForm */
/* @var $socialLoginForm SocialLoginForm */
/* @var $this FrontController */
/* @var $attributes */
?>
<?if (!empty($attributes['image'])) :?>
	<img src="<?=$attributes['image']?>" alt="" class="social-image-avatar" />
<?endif;?>
<h2 class="h2-social-ok">Здравствуйте, <?=$attributes['name']?>!</h2>
<?if (!empty($notActivatedSocialMember)) :?>
	Вам необходимо активировать профиль на сайте, пройдя по ссылке и письма, которое мы выслали вам на ящик <?=$notActivatedSocialMember->member->email?>.
	<div class="clear"></div>
	<div class="social-second-chance-label">Если вы указали неправильный адрес почты, то вы можете указать новые данные ниже:</div>
<?else :?>
	Продолжив, вы сможете входить на Сайт без ввода пароля, для авторизации будет достаточно одного клика.
	<div class="clear"></div>
<?endif;?>


<div class="social-possibility">
	<div class="social-possibility__title">У вас уже есть профиль на Сайте?</div>

	<input type="button" class="form-type-button smallbutton<?if (!empty($attributes['email']) && !empty($attributes['trustedByEmail'])) :?> auth_by_email<?endif;?>" value="нет" data-type="new" /> | <input type="button" class="form-type-button smallbutton" value="да" data-type="old" />

</div>

<div class="soc-registration-form" style="<?if (empty($_POST['LoginForm'])) :?>display: none;<?endif;?>" id="soc_form_old">


	<?$form = $this->beginWidget('CActiveForm',
		array(
			'id'=>'login_form',
			'enableAjaxValidation' => true,
			'enableClientValidation' => true,
			'clientOptions' => array('validateOnSubmit' => true),
			'htmlOptions' => array(
				'class' => 'form-signin',
				'name'=>'login_form',
			),
		)
	);?>

	<div class="social-form-info">
		Укажите логин и пароль на Сайте
	</div>

	<div class="pb10">
		<?=$form->errorSummary($loginForm, '<div class="alert alert-error">', '</div>'); ?>


		<div class="pb10">
			<?=$form->textField($loginForm,'email', array('class' => 'text width186', 'placeholder' => 'логин') ); ?>
		</div>
		<div class="pb10">
			<?=$form->passwordField($loginForm,'password', array('class' => 'text width186', 'placeholder' => 'пароль') ); ?>
		</div>

		<input type="submit" class="button smallbutton" value="Сохранить" name="LoginForm[submit]" />
	</div>
	<?$this->endWidget();?>

</div>

<div class="soc-registration-form" style="padding-right: 10px;<?if (empty($_POST['SocialLoginForm'])) :?> display: none;<?endif;?>" id="soc_form_new">


	<?$form = $this->beginWidget('CActiveForm',
		array(
			'id'=>'social_login_form',
			'enableAjaxValidation' => true,
			'enableClientValidation' => true,
			'clientOptions' => array('validateOnSubmit' => true),
			'htmlOptions' => array(
				'class' => 'form-signin form-signin-right',
				'name'=>'social_login_form',
			),
		)
	);?>
	<?=$form->errorSummary($socialLoginForm, '<div class="alert alert-error">', '</div>'); ?>
	<?if (empty($attributes['email']) || empty($attributes['trustedByEmail'])) :?>
		<div class="social-form-info">
			Профиль создан, осталось указать почту для активации.
		</div>
		<div class="pb10">
			<?=$form->emailField($socialLoginForm,'email', array('class' => 'text width186', 'placeholder' => 'укажите ваш email') ); ?>
			<button class="button smallbutton" type="submit" name="SocialLoginForm[submit]">Сохранить</button>
		</div>
	<?else :?>
		<?=$form->hiddenField($socialLoginForm,'email'); ?>
		<button class="button smallbutton" type="submit" name="SocialLoginForm[submit]">Сохранить</button>
	<?endif;?>

	<?$this->endWidget();?>

</div>
<div class="clear"></div>

<script type="text/javascript">
	$(document).ready(function(){
		$('.form-type-button').click(function(){
			if ($(this).hasClass('auth_by_email')) {
				$('#social_login_form').trigger('submit');
				return false;
			}
			$('.soc-registration-form').hide();
			$('#soc_form_' + $(this).data('type')).show();
			return false;
		})
	});
</script>