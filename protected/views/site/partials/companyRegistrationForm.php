		<fieldset>
			<legend>Your company's details</legend>
			<div class="row">
				<?php echo CHtml::activeLabel($company, 'name') ?>
				<?php echo CHtml::activeTextField($company, 'name', array('class' => 'text')) ?>
				<?php echo CHtml::error($company, 'name') ?>
			</div>
			<div class="row">
				<?php echo CHtml::activeLabel($company, 'url') ?>
				<?php echo CHtml::activeTextField($company, 'url', array('class' => 'text tooltip', 'title' => $company->hints('url') )) ?>
				<?php echo CHtml::error($company, 'url') ?>
			</div>
			<div class="row">
				<?php echo CHtml::activeLabel($company, 'subdomain') ?>
				<?php echo CHtml::activeTextField($company, 'subdomain', array('class' => 'text tooltip', 'title' => $company->hints('subdomain') )) ?>
				<?php echo CHtml::error($company, 'subdomain') ?>
			</div>
			<div class="row">
				<?php echo CHtml::activeLabel($company, 'allowedDomains') ?>
				<?php echo CHtml::activeTextField($company, 'allowedDomains', array('class' => 'text tooltip', 'title' => $company->hints('allowedDomains') )) ?>
				<?php echo CHtml::error($company, 'allowedDomains') ?>
				
			</div>
		</fieldset>
