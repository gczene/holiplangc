<div id="colorboxPartial">
	<form class="form">
		<div class="row">
			<label for="Department_label">Department's name</label>
			<input class="text" value="<?php echo $department['label'] ?>" type="text" id="Department_label" name="Department[label]"  />
		</div>
		<div class="row">
			<label for="Department_new">New Child Department</label>
			<input class="text"  type="text" id="Department_new" name="Department[new]"  />
			<div class='errorMessage'>Minimum 2 characters</div>
		</div>
		<div class='row'>
			<input type='button' class='submit' value='Save' />
		</div>
		<input type="hidden" name="Department[_id]" value="<?php echo $id; ?>" />
	</form>
</div>
<script>
	$(function(){
		$('#colorboxPartial .errorMessage').hide();
		$('#colorboxPartial .submit').click(function(){
			var $this = $(this);
			var $n = $('#Department_new').val();
			
			if ( $n.replace(/ /g, '') != '' && $n.replace(/ /g, '').length ==1 ){
				$('#Department_new').closest('.row').children('.errorMessage').show();
			}
			else{
				$('#Department_new').closest('.row').children('.errorMessage').hide();
				var data = $this.closest('form').serialize();
				$.post('/organigram/addDepartment', data , function(data){
					console.log(data);
				})
				
			}
			
			$.colorbox.resize();
		})
	})

</script>

