
$(document).ready(function(){
	
$.widget("ui.tooltip", $.ui.tooltip, {
    options: {
        content: function () {
            return $(this).prop('title');
        }
    }
});	
	$('#Companies_url').blur(function(){
		var url =$(this).val();
		
		function sd(str){
			str = str.replace(/https?:\/\/|www\./g, '');
			str = str.split('.');
			str.splice(str.length-1 ,1);
			str = str.join('-')
			return str.replace(/\.|_/g, '-').toLowerCase();
		}
		
		$('#Companies_subdomain').val(sd(url));
		
	})
	
	$('.tooltip').tooltip();
	
})