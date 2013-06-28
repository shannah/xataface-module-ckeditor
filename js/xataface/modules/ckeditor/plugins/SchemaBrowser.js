//require <xataface/ui/SchemaBrowser.js>
//require <ckeditor.js>
//require-css <xataface/modules/ckeditor/plugins/schemabrowser/SchemaBrowser.css>



(function(){
	var SchemaBrowser = XataJax.load('xataface.ui.SchemaBrowser');
	var $ = jQuery;
	//alert('here');
	//CKEDITOR.config.toolbar_XBasic = [['button-pre', 'Bold', 'Italic', 'Underline', 'InsertMacro']];
	CKEDITOR.config.toolbar_XBasic = $.merge([], CKEDITOR.config.toolbar_Full);
	CKEDITOR.config.toolbar_XBasic.push(['SchemaBrowser']);
	
	//[['button-pre', 'Bold', 'Italic', 'Underline', 'InsertMacro']];
	CKEDITOR.plugins.add('SchemaBrowser', {
		init: function(editor){
			
			
			
			
			var pluginName = 'SchemaBrowser';
			//CKEDITOR.dialog.add(pluginName, this.path + 'dialogs/foo.js');
			
			
			//editor.addCss('div.xf-schemabrowser-section-header{ border: 1px dotted #8cacbb; background-image: url('+XATAFACE_MODULES_HTMLREPORTS_URL+'/images/section_header.png); background-repeat: no-repeat;padding: 10px 0px;}');
			//editor.addCss('div.xf-schemabrowser-section-footer{ border: 1px dotted #8cacbb; background-image: url('+XATAFACE_MODULES_HTMLREPORTS_URL+'/images/section_footer.png); background-repeat: no-repeat;padding: 10px 0px;}');
			
			
			
			/**
			 * The button to add a field to the template.
			 */
			editor.addCommand(pluginName, new CKEDITOR.command(editor, {
				
				exec: function(){
					//alert(editor.element);
					var tableName = editor.element.getAttribute('data-xf-schemabrowser-tablename');
					if ( !tableName ){
						// If no table name has been specified, let's try to guess it
						var tableName = $('[name="-table"]', editor.element.form).val();
						
					}
					
					if ( !tableName ){
						alert("Please select a table first");
						return;
					}
					
					XataJax.ready(function(){
					
						
					
						var div = document.createElement('div');
						
						var sb = new SchemaBrowser({
							query: {'-table': tableName}
						});
						sb.bind('fieldClicked', function(event){
							try {
								editor.insertText(event.macro);
							} catch (e){
								alert('Please select the position in the template where you would like this field to be inserted.');
							}
						});
						sb.update();
						
						$(div).append(sb.getElement());
						//$(div).append(sb.prevButton.getElement());
						//$(div).append(btn);
						$('body').append(div);
						$(div).dialog({
							title: 'Insert Field',
							width: 300,
							height: $(window).height(),
							position: ['right','top'],
							zIndex: 9999
							
							
						});
						//$('body').append(sb.getElement());
					});
				}
			
			}));
			//alert('here');
			editor.ui.addButton('SchemaBrowser', {
				label: 'Insert Field',
				command: pluginName
			});
			
			
			
			
		}
	
	});
	
	
	
})();