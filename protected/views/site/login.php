<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Login';
$this->breadcrumbs=array(
	'Login',
);
?>
<div class="positionCenter registerForm">

	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'login-form',
		'enableClientValidation'=>true,
		'clientOptions'=>array(
			'validateOnSubmit'=>true,
		),
		'htmlOptions' => array(
			'class' => 'form',
		),
	)); ?>
	<fieldset>
		<legend>
			<?php if ($validated) : ?>
				Your account is activated!<br /> Log in with your credentials now!
			<?php else:  ?>
				Log in with your credentials
			<?php endif; ?>
		</legend>


		<div class="row">
			<?php echo $form->labelEx($model,'email'); ?>
			<?php echo $form->textField($model,'email', array('class' => 'text')); ?>
			<?php echo $form->error($model,'email'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'password'); ?>
			<?php echo $form->passwordField($model,'password', array('class' => 'text')); ?>
			<?php echo $form->error($model,'password'); ?>
		</div>

		<div class="squaredThree">
			<?php echo $form->checkBox($model,'rememberMe', array('checked' => 'checked')); ?>
			<?php echo $form->label($model,'rememberMe', array('class' => 'squaredThree')); ?>
			<?php echo $form->error($model,'rememberMe'); ?>
			<div class="label" for="LoginForm_rememberMe">Remember Me</div>
		</div>

		<div class="row buttons">
			<?php echo CHtml::submitButton('Login', array('class' => 'submit')); ?>
		</div>
	</fieldset>
	<?php $this->endWidget(); ?>
</div>
<script>
	$(function(){
		$('.squaredThree .label').click(function(){
			$('.squaredThree label').trigger('click');
		})
	})
	</script>