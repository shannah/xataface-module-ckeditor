//require <ckeditor.js>
//require <jquery.packed.js>

(function(){
	var $ = jQuery;
	
	registerXatafaceDecorator(function(node){
		
		
		$('textarea.xf-ckeditor', node).each(function(){
		
			var customConfig = {};
			if ( $(this).attr('data-xf-ckeditor-config') ){
				var strconf = $(this).attr('data-xf-ckeditor-config');
				var newConf = {};
				try {
					eval('newConf='+strconf+';');
					
				} catch (e){}
				$.extend(customConfig, newConf);
			}
			CKEDITOR.replace(this, customConfig);
		});
	});

})();