function org(org, compName){
	this.org = org;
	this.compName = compName;
	this.getItems = function(org){
		for (var id in org){
			console.log(id)
		}
	}
	this.html = '';
	
	this.run = function(){
		if (typeof this.org != 'undefined'){
			
			this.html = this.createList();
			$('#chart-source li').append(this.html )
			.orgChart({container: $('#chart-container')});
		}
	}
	
	this.createList = function(o){
		
		if (typeof o != 'undefined'){
			item = o;
		}
		else
			item = this.org;
		
		var html = '<UL>';
		for(var id in item){
			html += '<li ><span>' + item[id].label + '</span>'
				+ '<a class="edit" onclick="editOrg(\'' + id + '\');" id="' + id + '">Edit</a>';
			if (typeof item[id].departments == 'object' && item[id].departments.length != 0){
				html += this.createList(item[id].departments);
			}
			html += '</li>';
		}
		html += '</ul>';
		return html;
	}
	
}

function editOrg(id){
	$.colorbox({href: '/organigram/getForm/id/' + id});
}

$(document).ready(function(){
		var o = new org(organogram, compName);
		o.run();
		$(window).resize(function(){
//			if ($("#colorbox").css("display")=="block") {  
//			} 
		})
})

