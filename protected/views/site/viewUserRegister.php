	<div class="registerForm positionCenter">
		<?php echo CHtml::beginForm('', 'post', array('class' => 'form')); ?>
		
		<?php $this->renderPartial('partials/userRegistrationForm', array('user' => $user)); ?>
		
			<div class="row buttons">
				<?php echo CHtml::submitButton('Register', array('class' => 'submit', 'name' => 'register')) ?>
			</div>

		<?php echo CHtml::endForm(); ?>
	</div>
