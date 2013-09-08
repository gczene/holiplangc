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
			html += '<li id="' + id + '">' + item[id].label;
			if (typeof item[id].departments == 'object' && item[id].departments.length != 0){
				html += this.createList(item[id].departments);
			}
			html += '</li>';
		}
		html += '</ul>';
		return html;
	}
	
}

$(document).ready(function(){
		var o = new org(organogram, compName);
		o.run();
})

