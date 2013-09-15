<div id="colorboxPartial">
	<form class="form">
		<input id="parent" type="hidden" value="<?php echo $parentId; ?>" />
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
	</form>
</div>
<script>
	$(function(){
		$('#colorboxPartial .errorMessage').hide();
		$('#colorboxPartial .submit').click(function(){
			var $n = $('#Department_new').val();
//			alert($n.lenth + ' ' + ($n.replace(/ /g, '') != '') )
			if ( $n.replace(/ /g, '') != '' && $n.length ==1 ){
				$('#Department_new').closest('.row').children('.errorMessage').show()
			}
			
			$.colorbox.resize();
		})
	})

</script>

