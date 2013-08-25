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
