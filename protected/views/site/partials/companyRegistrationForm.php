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
