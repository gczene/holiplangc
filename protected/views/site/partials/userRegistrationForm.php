		<fieldset>
			<legend>Your details</legend>
			<div class="row">
				<?php echo CHtml::activeLabel($user, 'firstName') ?>
				<?php echo CHtml::activeTextField($user, 'firstName', array('class' => 'text')) ?>
				<?php echo CHtml::error($user, 'firstName') ?>
			</div>
			<div class="row">
				<?php echo CHtml::activeLabel($user, 'lastName') ?>
				<?php echo CHtml::activeTextField($user, 'lastName', array('class' => 'text')) ?>
				<?php echo CHtml::error($user, 'lastName') ?>
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
