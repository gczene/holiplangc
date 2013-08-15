


<div class="positionCenter registerForm">
	<?php
//	echo $form; 
	?>
	
	<?php echo CHtml::beginForm('', 'post', array('class' => 'form')); ?>
	<fieldset>
		<legend>Your company's details</legend>
		<div class="row">
			<?php echo CHtml::activeLabel($company, 'name') ?>
			<?php echo CHtml::activeTextField($company, 'name', array('class' => 'text')) ?>
			<?php echo CHtml::error($company, 'name') ?>
		</div>
		<div class="row">
			<?php echo CHtml::activeLabel($company, 'url') ?>
			<?php echo CHtml::activeTextField($company, 'url', array('class' => 'text')) ?>
			<?php echo CHtml::error($company, 'url') ?>
		</div>
		<div class="row">
			<?php echo CHtml::activeLabel($company, 'subdomain') ?>
			<?php echo CHtml::activeTextField($company, 'subdomain', array('class' => 'text')) ?>
			<?php echo CHtml::error($company, 'subdomain') ?>
		</div>
	</fieldset>
	<fieldset>
		<legend>Your details</legend>
		<div class="row">
			<?php echo CHtml::activeLabel($user, 'first_name') ?>
			<?php echo CHtml::activeTextField($user, 'first_name', array('class' => 'text')) ?>
			<?php echo CHtml::error($user, 'first_name') ?>
		</div>
		<div class="row">
			<?php echo CHtml::activeLabel($user, 'last_name') ?>
			<?php echo CHtml::activeTextField($user, 'last_name', array('class' => 'text')) ?>
			<?php echo CHtml::error($user, 'last_name') ?>
		</div>
		<div class="row">
			<?php echo CHtml::activeLabel($user, 'email') ?>
			<?php echo CHtml::activeTextField($user, 'email', array('class' => 'text')) ?>
			<?php echo CHtml::error($user, 'email') ?>
		</div>
		<div class="row">
			<?php echo CHtml::activeLabel($user, 'password') ?>
			<?php echo CHtml::activePasswordField($user, 'password', array('class' => 'text')) ?>
			<?php echo CHtml::error($user, 'password') ?>
		</div>
		<div class="row">
			<?php echo CHtml::activeLabel($user, 'password2') ?>
			<?php echo CHtml::activePasswordField($user, 'password2', array('class' => 'text')) ?>
			<?php echo CHtml::error($user, 'password2') ?>
		</div>
	</fieldset>
		<div class="row buttons">
			<?php echo CHtml::submitButton('Register', array('class' => 'submit', 'name' => 'register')) ?>
		</div>
	
	<?php echo CHtml::endForm(); ?>
	
</div>